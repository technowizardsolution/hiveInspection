//
//  HiveSetupVC.swift
//  HiveInspection
//
//  Created by LN-iMAC-004 on 26/08/23.
//

import UIKit

class HiveSetupVC : UIViewController {

    @IBOutlet weak var onBtnOriginOutlet : UIButton!
    @IBOutlet weak var onBtnDeepsOutlet : UIButton!
    @IBOutlet weak var onBtnMediumsOutlet : UIButton!
    @IBOutlet weak var onBtnSaveOutlet : LetsButton!
    @IBOutlet weak var onBtnAddAHiveOutlet : LetsButton!
    @IBOutlet weak var onBtnStartInspectingOutlet : LetsButton!
    @IBOutlet weak var queenIntroducedDatePickerOutlet: UIDatePicker!
    @IBOutlet weak var buildDatePickerOutlet: UIDatePicker!
    @IBOutlet weak var txtHiveLocationOutlet: UITextField!
    @IBOutlet weak var txtHiveNameOutlet: UITextField!
    @IBOutlet weak var lblOROutlet: UILabel!
    @IBOutlet weak var lblSetupHiveOutlet: UILabel!
    var hiveSetupDataArray : [HiveSetup]?
    var hiveSetupDeepsDataArray : [HiveSetup]?
    var hiveSetupMediumDataArray : [HiveSetup]?
    var hiveSetupVM : HiveSetupViewModel?
    var hiveListModelData : HiveListModelData?
    var showBackbutton = false
    override func viewDidLoad() {
        super.viewDidLoad()
        showTransparentNavigationBar()
        if showBackbutton {
            closeButton()
        }
        setupHiveOriginData()
        setupHiveDeepsData()
        setupHiveMediumData()
        setupButtons()
        hiveSetupVM = HiveSetupViewModel()
        hiveSetupVM?.delegate = self
        setupPrefilledData()
    }

    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        showTransparentNavigationBar()
        if showBackbutton {
            closeButton()
        }
        setupPrefilledData()
    }
}

extension HiveSetupVC {
    private func setupPrefilledData() {
        if hiveListModelData != nil {
            defer {
                setPopUpButton()
                setPopUpDeepsButton()
                setPopUpMediumButton()
            }
            self.title = "Update Hive"
            closeButton()
            txtHiveLocationOutlet.text = hiveListModelData?.location ?? ""
            txtHiveNameOutlet.text = hiveListModelData?.hiveName ?? ""
            lblSetupHiveOutlet.text = "Hive Details"
            
            if let buildDate = hiveListModelData?.buildDate?.toDate("yyyy-MM-dd") {
                if buildDate.daysUntilNow.intValue > 0 {
                    let date = Date().minusDays(buildDate.daysUntilNow.uintValue)
                    buildDatePickerOutlet.date = date
                }else {
                    let date = Date().plusDays(buildDate.daysUntilNow.uintValue)
                    buildDatePickerOutlet.date = date
                }
            }
            
            if let queenIntroducedDate =  hiveListModelData?.queenIntroduced?.toDate("yyyy-MM-dd") {
                if queenIntroducedDate.daysUntilNow.intValue > 0 {
                    let date = Date().minusDays(queenIntroducedDate.daysUntilNow.uintValue)
                    queenIntroducedDatePickerOutlet.date = date
                }else {
                    let plusDate = -queenIntroducedDate.daysUntilNow.intValue
                    let date = Date().plusDays(UInt(plusDate))
                    queenIntroducedDatePickerOutlet.date = date
                }
            }
        }
    }
}

extension HiveSetupVC : HiveSetupResponse {
    func getHiveSetupResponse(_ model: HiveSetupModel) {
        if (model.status ?? 1) == 1, let _ = model.data {
            if hiveListModelData != nil {
                self.navigationController?.popViewController(animated: true)
            }else {
                let dvc : HiveListVC = mainStoryBoard.instantiateViewController(withIdentifier: "HiveListVC") as! HiveListVC
                let navVC : UINavigationController = UINavigationController(rootViewController: dvc)
                navVC.showColoredNavigationBar(.white)
                appDelegate.window?.switchRootViewController(to: navVC)
            }
        }else {
            UIAlertController.actionWith(andMessage: model.message ?? "", getStyle: .alert,controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in }
        }
    }
    
    func failureResponse(_ error: String) {
        UIAlertController.actionWith(andMessage: error, getStyle: .alert,controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in }
    }
}

extension HiveSetupVC {
    @IBAction private func onBtnSaveAction(_ sender : UIButton) {
        self.vibrate()
    }

    @IBAction private func onBtnAddAHiveAction(_ sender : UIButton) {
        self.vibrate()
//        sender.isEnabled = false
        checkValidation()
    }

    @IBAction private func onBtnStartInvestingAction(_ sender : UIButton) {
        self.vibrate()
        let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "HiveInspect1VC") as! HiveInspect1VC
        if hiveListModelData != nil {
            dvc.hiveId = hiveListModelData?.hiveid?.string ?? ""
        }
        navigationController?.pushViewController(dvc, animated: true)
    }
}

extension HiveSetupVC {
    func checkValidation() {
        var validation = AddAHiveValidation()
        validation.hiveName = txtHiveNameOutlet.text ?? ""
        validation.hiveLocation = txtHiveLocationOutlet.text ?? ""
        let validated = checkAddAHiveValidation(validationModel: validation)
        if validated.0 {
            guard let buildDate = buildDatePickerOutlet.date.toString("yyyy-MM-dd") else { return }
            guard let queenIntroducedDate = queenIntroducedDatePickerOutlet.date.toString("yyyy-MM-dd") else { return }
            guard let getHiveSetupDataOrigin = hiveSetupDataArray?.filter({$0.isSelected}).first else { return }
            guard let getHiveSetupDeeps = hiveSetupDeepsDataArray?.filter({$0.isSelected}).first else { return }
            guard let getHiveSetupMedium = hiveSetupMediumDataArray?.filter({$0.isSelected}).first else { return }
            if hiveListModelData != nil {
                let param : [String : Any] = [ "data" :[
                    "hive_name" : txtHiveNameOutlet.text ?? "",
                    "location": txtHiveLocationOutlet.text ?? "",
                    "build_date": buildDate,
                    "origin": getHiveSetupDataOrigin.name,
                    "deeps": getHiveSetupDeeps.name,
                    "mediums": getHiveSetupMedium.name,
                    "queen_introduced": queenIntroducedDate,
                    "user_id": Constants.getUserId(),
                    "hive_id" : self.hiveListModelData?.hiveid?.string ?? ""
                ]]
                hiveSetupVM?.callAPI(param)
            }else {
                let param : [String : Any] = [ "data" :[
                    "hive_name" : txtHiveNameOutlet.text ?? "",
                    "location": txtHiveLocationOutlet.text ?? "",
                    "build_date": buildDate,
                    "origin": getHiveSetupDataOrigin.name,
                    "deeps": getHiveSetupDeeps.name,
                    "mediums": getHiveSetupMedium.name,
                    "queen_introduced": queenIntroducedDate,
                    "user_id": Constants.getUserId()
                ]]
                hiveSetupVM?.callAPI(param)
            }
        }else {
            UIAlertController.actionWith(andMessage: validated.1, getStyle: .alert,controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in }
        }
    }
    
    func setupHiveOriginData() {
        defer {
            setPopUpButton()
        }
        hiveSetupDataArray = []
        hiveSetupDataArray?.append(HiveSetup(name: "Nuc", isSelected: false))
        hiveSetupDataArray?.append(HiveSetup(name: "Swarm", isSelected: false))
        hiveSetupDataArray?.append(HiveSetup(name: "Split", isSelected: false))
        hiveSetupDataArray?.append(HiveSetup(name: "Scratch", isSelected: false))
        hiveSetupDataArray?.append(HiveSetup(name: "Package", isSelected: false))
        hiveSetupDataArray?.append(HiveSetup(name: "Other", isSelected: false))
        
        if let originIndex = hiveSetupDataArray?.firstIndex(where: {$0.name == (hiveListModelData?.origin ?? "")}) {
            hiveSetupDataArray?[originIndex].isSelected = true
            onBtnOriginOutlet.setTitle(hiveListModelData?.origin, for: .normal)
        }else {
            hiveSetupDataArray?[0].isSelected = true
        }
    }

    func setupHiveDeepsData() {
        defer {
            setPopUpDeepsButton()
        }
        hiveSetupDeepsDataArray = []
        hiveSetupDeepsDataArray?.append(HiveSetup(name: "1", isSelected: false))
        hiveSetupDeepsDataArray?.append(HiveSetup(name: "2", isSelected: false))
        hiveSetupDeepsDataArray?.append(HiveSetup(name: "3", isSelected: false))
        
        if let deepsIndex = hiveSetupDeepsDataArray?.firstIndex(where: {$0.name == (hiveListModelData?.deeps?.string ?? "")}) {
            hiveSetupDeepsDataArray?[deepsIndex].isSelected = true
            onBtnDeepsOutlet.setTitle(hiveListModelData?.deeps?.string ?? "", for: .normal)
        }else {
            hiveSetupDeepsDataArray?[0].isSelected = true
        }
    }

    func setupHiveMediumData() {
        defer {
            setPopUpMediumButton()
        }
        hiveSetupMediumDataArray = []
        hiveSetupMediumDataArray?.append(HiveSetup(name: "1", isSelected: false))
        hiveSetupMediumDataArray?.append(HiveSetup(name: "2", isSelected: false))
        hiveSetupMediumDataArray?.append(HiveSetup(name: "3", isSelected: false))
        if let mediumIndex = hiveSetupMediumDataArray?.firstIndex(where: {$0.name == (hiveListModelData?.mediums?.string ?? "")}) {
            hiveSetupMediumDataArray?[mediumIndex].isSelected = true
            onBtnMediumsOutlet.setTitle(hiveListModelData?.mediums?.string ?? "", for: .normal)
        }else {
            hiveSetupMediumDataArray?[0].isSelected = true
        }
    }

    func setPopUpButton(){
        let optionClosure = {(action: UIAction) in
            guard let index = self.hiveSetupDataArray?.firstIndex(where: {$0.name == action.title}) else { return }
            for (getIndex,_) in (self.hiveSetupDataArray ?? []).enumerated() {
                self.hiveSetupDataArray?[getIndex].isSelected = false
            }
            self.hiveSetupDataArray?[index].isSelected = true
        }
        var arrUIAction = [UIAction]()
        for hiveSetupData in hiveSetupDataArray ?? [] {
            arrUIAction.append(UIAction(title: hiveSetupData.name, state: hiveSetupData.isSelected ? .on : .off, handler: optionClosure))
        }
        onBtnOriginOutlet.menu = UIMenu(children: arrUIAction)
        onBtnOriginOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnOriginOutlet.changesSelectionAsPrimaryAction = true
        }
    }

    func setPopUpDeepsButton(){
        let optionClosure = {(action: UIAction) in
            guard let index = self.hiveSetupDeepsDataArray?.firstIndex(where: {$0.name == action.title}) else { return }
            for (getIndex,_) in (self.hiveSetupDeepsDataArray ?? []).enumerated() {
                self.hiveSetupDeepsDataArray?[getIndex].isSelected = false
            }
            self.hiveSetupDeepsDataArray?[index].isSelected = true
        }
        var arrUIAction = [UIAction]()
        for hiveSetupData in hiveSetupDeepsDataArray ?? [] {
            arrUIAction.append(UIAction(title: hiveSetupData.name, state: hiveSetupData.isSelected ? .on : .off, handler: optionClosure))
        }
        onBtnDeepsOutlet.menu = UIMenu(children: arrUIAction)
        onBtnDeepsOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnDeepsOutlet.changesSelectionAsPrimaryAction = true
        }
    }

    func setPopUpMediumButton(){
        let optionClosure = {(action: UIAction) in
            guard let index = self.hiveSetupMediumDataArray?.firstIndex(where: {$0.name == action.title}) else { return }
            for (getIndex,_) in (self.hiveSetupMediumDataArray ?? []).enumerated() {
                self.hiveSetupMediumDataArray?[getIndex].isSelected = false
            }
            self.hiveSetupMediumDataArray?[index].isSelected = true
        }
        var arrUIAction = [UIAction]()
        for hiveSetupData in hiveSetupMediumDataArray ?? [] {
            arrUIAction.append(UIAction(title: hiveSetupData.name, state: hiveSetupData.isSelected ? .on : .off, handler: optionClosure))
        }
        onBtnMediumsOutlet.menu = UIMenu(children: arrUIAction)
        onBtnMediumsOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnMediumsOutlet.changesSelectionAsPrimaryAction = true
        }
    }

    private func setupButtons() {
        func setupSaveButton() {
            onBtnSaveOutlet.isHidden = true
            onBtnSaveOutlet.setTitle("Save", for: .normal)
            onBtnSaveOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnSaveOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnSaveOutlet.cornerRadius = onBtnSaveOutlet.frame.height / 2
            onBtnSaveOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        func setupAddAHiveButton() {
            onBtnAddAHiveOutlet.setTitle(hiveListModelData == nil ? "Add a Hive" : "Update Hive", for: .normal)
            onBtnAddAHiveOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnAddAHiveOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnAddAHiveOutlet.cornerRadius = onBtnAddAHiveOutlet.frame.height / 2
            onBtnAddAHiveOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        func setupStartInspectingButton() {
            onBtnStartInspectingOutlet.isHidden = hiveListModelData == nil
            lblOROutlet.isHidden = hiveListModelData == nil
            onBtnStartInspectingOutlet.setTitle("Start inspecting!", for: .normal)
            onBtnStartInspectingOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnStartInspectingOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnStartInspectingOutlet.cornerRadius = onBtnStartInspectingOutlet.frame.height / 2
            onBtnStartInspectingOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        setupSaveButton()
        setupAddAHiveButton()
        setupStartInspectingButton()
    }
}
