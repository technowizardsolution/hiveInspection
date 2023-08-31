//
//  HiveInspect2VC.swift
//  HiveInspection
//
//  Created by LN-iMAC-004 on 31/08/23.
//

import UIKit
import FlexibleSteppedProgressBar

class CellT_HiveInspect2 : UITableViewCell {
    @IBOutlet weak var onSwitchOutlet : UISwitch!
    @IBOutlet weak var onSwitchWithTextOutlet : UISwitch!
    @IBOutlet weak var onDatePickerOutlet : UIDatePicker!
    @IBOutlet weak var onBtnDropDownOutlet : UIButton!
    @IBOutlet weak var lblTitleOutlet : UILabel!
    var tempermentData : [HiveSetup] = []
    var populationData : [HiveSetup] = []
    var solidUniformFrameData : [HiveSetup] = []
    var slightlySpottyFramesData : [HiveSetup] = []
    var spottyFramesData : [HiveSetup] = []
    var broodData : [HiveSetup] = []
    var honeyData : [HiveSetup] = []
    var pollenData : [HiveSetup] = []

    override func awakeFromNib() {
        super.awakeFromNib()
    }

    func setPopUpButtonTemperment(completion : @escaping (String) -> ()) {
        let optionClosure = {(action: UIAction) in
            completion(action.title)
        }
        var arrUIAction = [UIAction]()
        for hiveSetupData in tempermentData {
            arrUIAction.append(UIAction(title: hiveSetupData.name, state: hiveSetupData.isSelected ? .on : .off, handler: optionClosure))
        }
        onBtnDropDownOutlet.menu = UIMenu(children: arrUIAction)
        onBtnDropDownOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnDropDownOutlet.changesSelectionAsPrimaryAction = true
        }
    }

    func setPopUpButtonPopulation(completion : @escaping (String) -> ()) {
        let optionClosure = {(action: UIAction) in
            completion(action.title)
        }
        var arrUIAction = [UIAction]()

        for hiveSetupData in populationData {
            arrUIAction.append(UIAction(title: hiveSetupData.name, state: hiveSetupData.isSelected ? .on : .off, handler: optionClosure))
        }
        onBtnDropDownOutlet.menu = UIMenu(children: arrUIAction)
        onBtnDropDownOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnDropDownOutlet.changesSelectionAsPrimaryAction = true
        }
    }

    func setPopUpButtonSolidUniformframes(completion : @escaping (String) -> ()) {
        let optionClosure = {(action: UIAction) in
            completion(action.title)
        }
        var arrUIAction = [UIAction]()
        for hiveSetupData in solidUniformFrameData {
            arrUIAction.append(UIAction(title: hiveSetupData.name, state: hiveSetupData.isSelected ? .on : .off, handler: optionClosure))
        }
        onBtnDropDownOutlet.menu = UIMenu(children: arrUIAction)
        onBtnDropDownOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnDropDownOutlet.changesSelectionAsPrimaryAction = true
        }
    }

    func setPopUpButtonSlightlySpottyframes(completion : @escaping (String) -> ()) {
        let optionClosure = {(action: UIAction) in
            completion(action.title)
        }
        var arrUIAction = [UIAction]()
        for hiveSetupData in slightlySpottyFramesData {
            arrUIAction.append(UIAction(title: hiveSetupData.name, state: hiveSetupData.isSelected ? .on : .off, handler: optionClosure))
        }
        onBtnDropDownOutlet.menu = UIMenu(children: arrUIAction)
        onBtnDropDownOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnDropDownOutlet.changesSelectionAsPrimaryAction = true
        }
    }

    func setPopUpButtonSpottyframes(completion : @escaping (String) -> ()) {
        let optionClosure = {(action: UIAction) in
            completion(action.title)
        }
        var arrUIAction = [UIAction]()
        for hiveSetupData in spottyFramesData {
            arrUIAction.append(UIAction(title: hiveSetupData.name, state: hiveSetupData.isSelected ? .on : .off, handler: optionClosure))
        }
        onBtnDropDownOutlet.menu = UIMenu(children: arrUIAction)
        onBtnDropDownOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnDropDownOutlet.changesSelectionAsPrimaryAction = true
        }
    }

    func setPopUpButtonBrood(completion : @escaping (String) -> ()) {
        let optionClosure = {(action: UIAction) in
            completion(action.title)
        }
        var arrUIAction = [UIAction]()
        for hiveSetupData in broodData {
            arrUIAction.append(UIAction(title: hiveSetupData.name, state: hiveSetupData.isSelected ? .on : .off, handler: optionClosure))
        }
        onBtnDropDownOutlet.menu = UIMenu(children: arrUIAction)
        onBtnDropDownOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnDropDownOutlet.changesSelectionAsPrimaryAction = true
        }
    }

    func setPopUpButtonHoney(completion : @escaping (String) -> ()) {
        let optionClosure = {(action: UIAction) in
            completion(action.title)
        }
        var arrUIAction = [UIAction]()
        for hiveSetupData in honeyData {
            arrUIAction.append(UIAction(title: hiveSetupData.name, state: hiveSetupData.isSelected ? .on : .off, handler: optionClosure))
        }
        onBtnDropDownOutlet.menu = UIMenu(children: arrUIAction)
        onBtnDropDownOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnDropDownOutlet.changesSelectionAsPrimaryAction = true
        }
    }

    func setPopUpButtonPollen(completion : @escaping (String) -> ()) {
        let optionClosure = {(action: UIAction) in
            completion(action.title)
        }
        var arrUIAction = [UIAction]()
        for hiveSetupData in pollenData {
            arrUIAction.append(UIAction(title: hiveSetupData.name, state: hiveSetupData.isSelected ? .on : .off, handler: optionClosure))
        }
        onBtnDropDownOutlet.menu = UIMenu(children: arrUIAction)
        onBtnDropDownOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnDropDownOutlet.changesSelectionAsPrimaryAction = true
        }
    }

    @IBAction func onSwitchChangeAction(_ sender: UISwitch) {
    }

    @IBAction func onSwitchWithTextChangeAction(_ sender: UISwitch) {
    }
}

class HiveInspect2VC : UIViewController {
    @IBOutlet private weak var tableview : UITableView!
    @IBOutlet weak var onBtnAddAHiveOutlet : LetsButton!
    @IBOutlet weak var onBtnNextOutlet : LetsButton!
    var selectedHiveNumber = ""
    var getHiveInspectData : [HiveInspectData]?
    var progressBar: FlexibleSteppedProgressBar!
    var tempermentData : [HiveSetup] = [HiveSetup(name: "Calm", isSelected: false), HiveSetup(name: "Nervous", isSelected: false), HiveSetup(name: "Aggressive", isSelected: false)]
    var populationData : [HiveSetup] = [HiveSetup(name: "Heavy", isSelected: false), HiveSetup(name: "Moderate", isSelected: false), HiveSetup(name: "Low", isSelected: false)]
    var solidUniformFrameData : [HiveSetup] = []
    var slightlySpottyFramesData : [HiveSetup] = []
    var spottyFramesData : [HiveSetup] = []
    var broodData : [HiveSetup] = [HiveSetup(name: "Heavy", isSelected: false), HiveSetup(name: "Moderate", isSelected: false), HiveSetup(name: "Low", isSelected: false)]
    var honeyData : [HiveSetup] = [HiveSetup(name: "Heavy", isSelected: false), HiveSetup(name: "Moderate", isSelected: false), HiveSetup(name: "Low", isSelected: false)]
    var pollenData : [HiveSetup] = [HiveSetup(name: "Heavy", isSelected: false), HiveSetup(name: "Moderate", isSelected: false), HiveSetup(name: "Low", isSelected: false)]
    override func viewDidLoad() {
        super.viewDidLoad()
        solidUniformFrameData = []
        slightlySpottyFramesData = []
        spottyFramesData = []
        for getData in 1...10 {
            solidUniformFrameData.append(HiveSetup(name: getData.string, isSelected: false))
            slightlySpottyFramesData.append(HiveSetup(name: getData.string, isSelected: false))
            spottyFramesData.append(HiveSetup(name: getData.string, isSelected: false))
        }
        self.title = "Hive Number \(selectedHiveNumber)"
        tableview.dataSource = self
        tableview.delegate = self
        setupData()
        setupButtons()
        showTransparentNavigationBar()
        closeButton()
        setupProgressBar()
    }

    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        showTransparentNavigationBar()
        closeButton()
//        pullDownButton { selectedString in
//            print(selectedString)
//        }
    }
}

extension HiveInspect2VC : UITableViewDataSource, UITableViewDelegate {
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return getHiveInspectData?.count ?? 0
    }

    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        guard let cell = tableView.dequeueReusableCell(withIdentifier: "CellT_HiveInspect2", for: indexPath) as? CellT_HiveInspect2 else { return UITableViewCell() }
        let item = getHiveInspectData?[indexPath.row]
        cell.lblTitleOutlet.text = item?.title
        cell.onSwitchOutlet.isHidden = !(item?.type == ._switch)
        cell.onSwitchWithTextOutlet.isHidden = !(item?.type == ._switchWithText)
        cell.onSwitchWithTextOutlet.layerCornerRadius = cell.onSwitchWithTextOutlet.height / 2
        cell.onDatePickerOutlet.isHidden = !(item?.type == .date)
        cell.onSwitchOutlet.layerCornerRadius = cell.onSwitchOutlet.height / 2
        cell.tempermentData = self.tempermentData
        cell.populationData = self.populationData
        cell.solidUniformFrameData = self.solidUniformFrameData
        cell.slightlySpottyFramesData = self.slightlySpottyFramesData
        cell.spottyFramesData = self.spottyFramesData
        cell.broodData = self.broodData
        cell.honeyData = self.honeyData
        cell.pollenData = self.pollenData
        cell.onBtnDropDownOutlet.isHidden = !(item?.type == .dropdown || item?.type == ._switchWithText)
        cell.onBtnDropDownOutlet.setTitle(self.getHiveInspectData?[indexPath.row].selectedTitle, for: .normal)

        switch (item?.title ?? "") {
        case "Temperment":
            cell.setPopUpButtonTemperment { selectedTitle in
                self.getHiveInspectData?[indexPath.row].selectedTitle = selectedTitle
                cell.onBtnDropDownOutlet.setTitle(selectedTitle, for: .normal)
                for (getIndex,_) in self.tempermentData.enumerated() {
                    self.tempermentData[getIndex].isSelected = false
                }
                if let index = self.tempermentData.firstIndex(where: {$0.name == selectedTitle}) {
                    self.tempermentData[index].isSelected = true
                }
                cell.layoutSubviews()
            }
            break
        case "Population":
            cell.setPopUpButtonPopulation { selectedTitle in
                self.getHiveInspectData?[indexPath.row].selectedTitle = selectedTitle
                cell.onBtnDropDownOutlet.setTitle(selectedTitle, for: .normal)
                if let index = self.populationData.firstIndex(where: {$0.name == selectedTitle}) {
                    self.populationData[index].isSelected = true
                }
                cell.layoutSubviews()
            }
            break
        case "Solid & Uniform frames":
            cell.setPopUpButtonSolidUniformframes { selectedTitle in
                self.getHiveInspectData?[indexPath.row].selectedTitle = selectedTitle
                cell.onBtnDropDownOutlet.setTitle(selectedTitle, for: .normal)
                for (getIndex,_) in self.solidUniformFrameData.enumerated() {
                    self.solidUniformFrameData[getIndex].isSelected = false
                }

                if let index = self.solidUniformFrameData.firstIndex(where: {$0.name == selectedTitle}) {
                    self.solidUniformFrameData[index].isSelected = true
                }
                cell.layoutSubviews()
            }
            break
        case "Slightly Spotty frames":
            cell.setPopUpButtonSlightlySpottyframes { selectedTitle in
                self.getHiveInspectData?[indexPath.row].selectedTitle = selectedTitle
                cell.onBtnDropDownOutlet.setTitle(selectedTitle, for: .normal)
                for (getIndex,_) in self.slightlySpottyFramesData.enumerated() {
                    self.slightlySpottyFramesData[getIndex].isSelected = false
                }
                if let index = self.slightlySpottyFramesData.firstIndex(where: {$0.name == selectedTitle}) {
                    self.slightlySpottyFramesData[index].isSelected = true
                }
                cell.layoutSubviews()
            }
            break
        case "Spotty frames":
            cell.setPopUpButtonSpottyframes { selectedTitle in
                self.getHiveInspectData?[indexPath.row].selectedTitle = selectedTitle
                cell.onBtnDropDownOutlet.setTitle(selectedTitle, for: .normal)
                for (getIndex,_) in self.spottyFramesData.enumerated() {
                    self.spottyFramesData[getIndex].isSelected = false
                }
                if let index = self.spottyFramesData.firstIndex(where: {$0.name == selectedTitle}) {
                    self.spottyFramesData[index].isSelected = true
                }
                cell.layoutSubviews()
            }
            break
        case "Brood":
            cell.setPopUpButtonBrood { selectedTitle in
                self.getHiveInspectData?[indexPath.row].selectedTitle = selectedTitle
                cell.onBtnDropDownOutlet.setTitle(selectedTitle, for: .normal)
                for (getIndex,_) in self.broodData.enumerated() {
                    self.broodData[getIndex].isSelected = false
                }
                if let index = self.broodData.firstIndex(where: {$0.name == selectedTitle}) {
                    self.broodData[index].isSelected = true
                }
                cell.layoutSubviews()
            }
            break
        case "Honey":
            cell.setPopUpButtonHoney { selectedTitle in
                self.getHiveInspectData?[indexPath.row].selectedTitle = selectedTitle
                cell.onBtnDropDownOutlet.setTitle(selectedTitle, for: .normal)
                for (getIndex,_) in self.honeyData.enumerated() {
                    self.honeyData[getIndex].isSelected = false
                }
                if let index = self.honeyData.firstIndex(where: {$0.name == selectedTitle}) {
                    self.honeyData[index].isSelected = true
                }
                cell.layoutSubviews()
            }
            break
        case "Pollen":
            cell.setPopUpButtonPollen { selectedTitle in
                self.getHiveInspectData?[indexPath.row].selectedTitle = selectedTitle
                cell.onBtnDropDownOutlet.setTitle(selectedTitle, for: .normal)
                for (getIndex,_) in self.pollenData.enumerated() {
                    self.pollenData[getIndex].isSelected = false
                }
                if let index = self.pollenData.firstIndex(where: {$0.name == selectedTitle}) {
                    self.pollenData[index].isSelected = true
                }
                cell.layoutSubviews()
            }
            break
        default:
            break
        }
        return cell
    }

    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        return 60
    }
}

extension HiveInspect2VC {
    private func setupButtons() {
        func setupAddAHiveButton() {
            onBtnAddAHiveOutlet.setTitle("Add a Hive", for: .normal)
            onBtnAddAHiveOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnAddAHiveOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnAddAHiveOutlet.cornerRadius = onBtnAddAHiveOutlet.frame.height / 2
            onBtnAddAHiveOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        func setupStartInspectingButton() {
            onBtnNextOutlet.setTitle("Next!", for: .normal)
            onBtnNextOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnNextOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnNextOutlet.cornerRadius = onBtnNextOutlet.frame.height / 2
            onBtnNextOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        setupAddAHiveButton()
        setupStartInspectingButton()
    }

    private func setupData() {
        getHiveInspectData = []
        getHiveInspectData?.append(HiveInspectData(title: "Temperment", type: .dropdown, selectedTitle: "Calm"))
        getHiveInspectData?.append(HiveInspectData(title: "Population", type: .dropdown, selectedTitle: "Heavy"))
        getHiveInspectData?.append(HiveInspectData(title: "Laying Pattern", type: .none, selectedTitle: ""))
        getHiveInspectData?.append(HiveInspectData(title: "Solid & Uniform frames", type: ._switchWithText, selectedTitle: "1"))
        getHiveInspectData?.append(HiveInspectData(title: "Slightly Spotty frames", type: ._switchWithText, selectedTitle: "1"))
        getHiveInspectData?.append(HiveInspectData(title: "Spotty frames", type: ._switchWithText, selectedTitle: "1"))
        getHiveInspectData?.append(HiveInspectData(title: "Normal Odor", type: .frontSwitch, selectedTitle: "Normal Odor"))
        getHiveInspectData?.append(HiveInspectData(title: "Brood", type: .dropdown, selectedTitle: "Heavy"))
        getHiveInspectData?.append(HiveInspectData(title: "Honey", type: .dropdown, selectedTitle: "Heavy"))
        getHiveInspectData?.append(HiveInspectData(title: "Pollen", type: .dropdown, selectedTitle: "Heavy"))
    }
}

extension HiveInspect2VC {
    @IBAction private func onBtnNextAction(_ sender : UIButton) {
        self.vibrate()
        let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "HiveInspect3VC") as! HiveInspect3VC
        navigationController?.pushViewController(dvc, animated: true)
    }

    @IBAction private func onBtnAddAHiveAction(_ sender : UIButton) {
        self.vibrate()
    }

    @IBAction private func onBtnSettingsAction(_ sender : UIButton) {
        self.vibrate()
        self.navigationController?.popViewController(animated: true)
    }
}

extension HiveInspect2VC : FlexibleSteppedProgressBarDelegate {
    func setupProgressBar() {
        progressBar = FlexibleSteppedProgressBar()
        progressBar.translatesAutoresizingMaskIntoConstraints = false
        self.view.addSubview(progressBar)

        let horizontalConstraint = progressBar.centerXAnchor.constraint(equalTo: self.view.centerXAnchor)
        let verticalConstraint = progressBar.topAnchor.constraint(
            equalTo: view.topAnchor,
            constant: 100
        )
        let widthConstraint = progressBar.widthAnchor.constraint(equalToConstant: CGFloat(self.view.frame.width - 20))
        let heightConstraint = progressBar.heightAnchor.constraint(equalToConstant: CGFloat(30))
        NSLayoutConstraint.activate([horizontalConstraint, verticalConstraint, widthConstraint, heightConstraint])

        // Customise the progress bar here
        progressBar.numberOfPoints = 5
        progressBar.lineHeight = 3
        progressBar.radius = 5
        progressBar.progressRadius = 1
        progressBar.progressLineHeight = 3
        progressBar.delegate = self
        progressBar.completedTillIndex = 2
        progressBar.displayStepText = false
        progressBar.useLastState = true
        progressBar.lastStateCenterColor = UIColor(named: HiveColor.ThemeBlue.rawValue)! //progressColor
        progressBar.selectedBackgoundColor = UIColor(named: HiveColor.ThemeBlue.rawValue)!//progressColor
        progressBar.selectedOuterCircleStrokeColor = UIColor(named: HiveColor.ThemeBlue.rawValue)!//backgroundColor
        progressBar.lastStateOuterCircleStrokeColor = UIColor(named: HiveColor.ThemeBlue.rawValue)!//backgroundColor
        progressBar.currentSelectedCenterColor = UIColor(named: HiveColor.ThemeBlue.rawValue)!//progressColor
        progressBar.currentSelectedTextColor = UIColor(named: HiveColor.ThemeBlue.rawValue)!//progressColor
        progressBar.currentIndex = 0
    }

    func progressBar(_ progressBar: FlexibleSteppedProgressBar, textAtIndex index: Int, position: FlexibleSteppedProgressBarTextLocation) -> String {
        return ""
    }
}
