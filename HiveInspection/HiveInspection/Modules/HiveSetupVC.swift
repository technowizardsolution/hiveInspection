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
    
    var hiveSetupDataArray : [HiveSetup]?
    var hiveSetupDeepsDataArray : [HiveSetup]?
    var hiveSetupMediumDataArray : [HiveSetup]?

    override func viewDidLoad() {
        super.viewDidLoad()
        showTransparentNavigationBar()
        setupHiveOriginData()
        setupHiveDeepsData()
        setupHiveMediumData()
        setupButtons()
    }

    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        showTransparentNavigationBar()
    }
}

extension HiveSetupVC {
    @IBAction private func onBtnSaveAction(_ sender : UIButton) {
        self.vibrate()
        let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "RateAppVC") as! RateAppVC
        navigationController?.pushViewController(dvc, animated: true)
    }

    @IBAction private func onBtnAddAHiveAction(_ sender : UIButton) {
        self.vibrate()
        self.viewDidLoad()
        self.viewWillAppear(true)
    }

    @IBAction private func onBtnStartInvestingAction(_ sender : UIButton) {
        self.vibrate()
        let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "HiveInspect1VC") as! HiveInspect1VC
        navigationController?.pushViewController(dvc, animated: true)
    }
}

extension HiveSetupVC {
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
    }

    func setupHiveDeepsData() {
        defer {
            setPopUpDeepsButton()
        }
        hiveSetupDeepsDataArray = []
        hiveSetupDeepsDataArray?.append(HiveSetup(name: "1", isSelected: false))
        hiveSetupDeepsDataArray?.append(HiveSetup(name: "2", isSelected: false))
        hiveSetupDeepsDataArray?.append(HiveSetup(name: "3", isSelected: false))
    }

    func setupHiveMediumData() {
        defer {
            setPopUpMediumButton()
        }
        hiveSetupMediumDataArray = []
        hiveSetupMediumDataArray?.append(HiveSetup(name: "1", isSelected: false))
        hiveSetupMediumDataArray?.append(HiveSetup(name: "2", isSelected: false))
        hiveSetupMediumDataArray?.append(HiveSetup(name: "3", isSelected: false))
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
            onBtnSaveOutlet.setTitle("Save", for: .normal)
            onBtnSaveOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnSaveOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnSaveOutlet.cornerRadius = onBtnSaveOutlet.frame.height / 2
            onBtnSaveOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        func setupAddAHiveButton() {
            onBtnAddAHiveOutlet.setTitle("Add a Hive", for: .normal)
            onBtnAddAHiveOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnAddAHiveOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnAddAHiveOutlet.cornerRadius = onBtnAddAHiveOutlet.frame.height / 2
            onBtnAddAHiveOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        func setupStartInspectingButton() {
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
