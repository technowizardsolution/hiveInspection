//
//  HiveInspect4VC.swift
//  HiveInspection
//
//  Created by LN-iMAC-004 on 31/08/23.
//

import UIKit
import FlexibleSteppedProgressBar

class CellT_HiveInspect4 : UITableViewCell {
    @IBOutlet weak var onSwitchWithTextOutlet : UISwitch!
    @IBOutlet weak var hiveInspectDatePicker: UIDatePicker!
    @IBOutlet weak var onBtnDropDownOutlet : UIButton!
    @IBOutlet weak var txtHiveDataOutlet : UITextField!
    @IBOutlet weak var bottomBorderOutlet : UIView!
    @IBOutlet weak var hiveTextStackViewOutlet : UIStackView!
    @IBOutlet weak var lblTitleOutlet : UILabel!
    var completionOnSwitchWithTextChanged : ((UISwitch) -> ())?
    var medicationData : [HiveSetup] = [HiveSetup(name: "Formic", isSelected: false), HiveSetup(name: "Apivar", isSelected: false), HiveSetup(name: "Other", isSelected: false)]

    func setPopUpButton(completion : @escaping (String) -> ()) {
        let optionClosure = {(action: UIAction) in
            self.onBtnDropDownOutlet.setTitle(action.title, for: .normal)
            completion(action.title)
        }
        var arrUIAction = [UIAction]()
        for hiveSetupData in medicationData {
            arrUIAction.append(UIAction(title: hiveSetupData.name, state: hiveSetupData.isSelected ? .on : .off, handler: optionClosure))
        }
        onBtnDropDownOutlet.menu = UIMenu(children: arrUIAction)
        onBtnDropDownOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnDropDownOutlet.changesSelectionAsPrimaryAction = true
        }
    }

    @IBAction func onSwitchWithTextChangeAction(_ sender: UISwitch) {
        completionOnSwitchWithTextChanged?(sender)
    }
}

class HiveInspect4VC : UIViewController {
    @IBOutlet private weak var tableview : UITableView!
    @IBOutlet weak var onBtnAddAHiveOutlet : LetsButton!
    @IBOutlet weak var onBtnNextOutlet : LetsButton!
    @IBOutlet weak var txtViewOutlet : LetsTextView!
    var selectedHiveNumber = ""
    
    var hiveInspectVM : HiveInspectViewModel?
    var hiveId = ""
    var getHiveInspectData : [HiveInspectData]?
    var getTotalHiveInspectData : [HiveInspectData]?
    var progressBar: FlexibleSteppedProgressBar!
    var medicationData : [HiveSetup] = [HiveSetup(name: "Formic", isSelected: false), HiveSetup(name: "Apivar", isSelected: false), HiveSetup(name: "Other", isSelected: false)]

    override func viewDidLoad() {
        super.viewDidLoad()
        self.title = "Hive Number \(selectedHiveNumber)"
        tableview.dataSource = self
        tableview.delegate = self
        setupData()
        setupButtons()
        showTransparentNavigationBar()
        closeButton()
        setupProgressBar()
        hiveInspectVM = HiveInspectViewModel()
        hiveInspectVM?.delegate = self
    }

    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        showTransparentNavigationBar()
        closeButton()
    }
    
    override func gotoBack() {
        navigationController?.popToRootViewController(animated: true)
    }
}

extension HiveInspect4VC : HiveInspectResponse {
    func getHiveInspectResponse(_ model: HiveInspectModel) {
        if (model.status ?? 1) == 1 {
            self.gotoBack()
        }else if (model.status ?? 0) == 2 {
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "LoginVC") as! LoginVC
            let navVC : UINavigationController = UINavigationController(rootViewController: dvc)
            navVC.showColoredNavigationBar(.white)
            appDelegate.window?.switchRootViewController(to: navVC)
        }
    }
    
    func failureResponse(_ error: String) {
        UIAlertController.actionWith(andMessage: error, getStyle: .alert,controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in }
    }
}

extension HiveInspect4VC : UITextFieldDelegate {
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        getHiveInspectData?[textField.tag].selectedTitle = (textField.text ?? "") + string
        return true
    }
}

extension HiveInspect4VC : UITableViewDataSource, UITableViewDelegate {
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return getHiveInspectData?.count ?? 0
    }

    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        guard let cell = tableView.dequeueReusableCell(withIdentifier: "CellT_HiveInspect4", for: indexPath) as? CellT_HiveInspect4 else { return UITableViewCell() }
        if let itemData = getHiveInspectData {
            let item = itemData[indexPath.row]
            cell.lblTitleOutlet.text = item.title
            cell.onBtnDropDownOutlet.isHidden = !(item.type == .dropdown || item.type == ._switchWithDropDown)
            cell.onSwitchWithTextOutlet.isHidden = !(item.type == .frontSwitch || item.type == ._switchWithDropDown || item.type == ._switchWithText || item.type == ._frontSwitchWithDate)
            cell.onBtnDropDownOutlet.isHidden = !(item.type == .dropdown || item.type == ._switchWithDropDown)
            cell.onSwitchWithTextOutlet.layerCornerRadius = cell.onSwitchWithTextOutlet.height / 2
            cell.hiveInspectDatePicker.isHidden = !(item.type == .date)
            
            cell.setPopUpButton { selectedTitle in
                self.getHiveInspectData?[indexPath.row].selectedTitle = selectedTitle
                cell.onBtnDropDownOutlet.setTitle(selectedTitle, for: .normal)
                for (getIndex,_) in self.medicationData.enumerated() {
                    self.medicationData[getIndex].isSelected = false
                }
                if let index = self.medicationData.firstIndex(where: {$0.name == selectedTitle}) {
                    self.medicationData[index].isSelected = true
                }
                cell.layoutSubviews()
            }
            cell.txtHiveDataOutlet.tag = indexPath.row
            cell.txtHiveDataOutlet.delegate = self
            cell.txtHiveDataOutlet.text = getHiveInspectData?[indexPath.row].selectedTitle
            if item.type == ._switchWithText {
                cell.hiveTextStackViewOutlet.isHidden = !(self.getHiveInspectData?[indexPath.row].isSwitchWithTextOn ?? false)
                cell.onBtnDropDownOutlet.isHidden = true
            }else if item.type == ._switchWithDropDown {
                cell.hiveTextStackViewOutlet.isHidden = true
                cell.onBtnDropDownOutlet.isHidden = !(self.getHiveInspectData?[indexPath.row].isSwitchWithTextOn ?? false)
            }else {
                cell.onBtnDropDownOutlet.isHidden = true
                cell.hiveTextStackViewOutlet.isHidden = true
            }
            cell.completionOnSwitchWithTextChanged = { _switch in
                self.getHiveInspectData?[indexPath.row].isSwitchWithTextOn = _switch.isOn
                if self.getHiveInspectData?[indexPath.row].type == ._switchWithText {
                    cell.hiveTextStackViewOutlet.isHidden = !(self.getHiveInspectData?[indexPath.row].isSwitchWithTextOn ?? false)
                    cell.onBtnDropDownOutlet.isHidden = true
                }else if self.getHiveInspectData?[indexPath.row].type == ._switchWithDropDown {
                    cell.hiveTextStackViewOutlet.isHidden = true
                    cell.onBtnDropDownOutlet.isHidden = !(self.getHiveInspectData?[indexPath.row].isSwitchWithTextOn ?? false)
                }else {
                    cell.onBtnDropDownOutlet.isHidden = true
                    cell.hiveTextStackViewOutlet.isHidden = true
                }
                cell.layoutSubviews()
            }
        }
        return cell
    }

    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        return 60
    }
}

extension HiveInspect4VC {
    private func setupButtons() {
        func setupAddAHiveButton() {
            onBtnAddAHiveOutlet.setTitle("Send Report", for: .normal)
            onBtnAddAHiveOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnAddAHiveOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnAddAHiveOutlet.cornerRadius = onBtnAddAHiveOutlet.frame.height / 2
            onBtnAddAHiveOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        func setupStartInspectingButton() {
            onBtnNextOutlet.setTitle("See History", for: .normal)
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
        getHiveInspectData?.append(HiveInspectData(title: "Feed Hive What?", type: ._switchWithText))
        getHiveInspectData?.append(HiveInspectData(title: "Install Medication What?", type: ._switchWithDropDown, selectedTitle: "Formic"))
        getHiveInspectData?.append(HiveInspectData(title: "Medication Reminder", type: .date))
        getHiveInspectData?.append(HiveInspectData(title: "Remove Medication", type: .frontSwitch))
        getHiveInspectData?.append(HiveInspectData(title: "Split Hive", type: .frontSwitch))
        getHiveInspectData?.append(HiveInspectData(title: "Re Queen", type: .frontSwitch))
        getHiveInspectData?.append(HiveInspectData(title: "Swap Brood Boxes", type: .frontSwitch))
        getHiveInspectData?.append(HiveInspectData(title: "Insulate / Winterize", type: .frontSwitch))
    }
    
    func updateDataAndPush() {
        func selectDate(_index : Int) {
            if let cell = tableview.cellForRow(at: IndexPath(row: _index, section: 0)) as? CellT_HiveInspect4 {
                let dateString = cell.hiveInspectDatePicker.date.toString("yyyy-MM-dd") ?? ""
                getHiveInspectData?[_index].selectedTitle = dateString
            }else {
                selectDate(_index: _index)
            }
        }
        for (_index,inspectData) in (getHiveInspectData ?? []).enumerated() {
            if inspectData.type == .frontSwitch {
                getHiveInspectData?[_index].selectedTitle = inspectData.isSwitchWithTextOn ? "1" : "0"
            }else if inspectData.type == .date {
                selectDate(_index: _index)
            }
        }
        getTotalHiveInspectData?.append(contentsOf: getHiveInspectData ?? [])
        hiveInspectVM?.callAPI(with: self.getTotalHiveInspectData ?? [], hiveId: self.hiveId, additionalNotes: txtViewOutlet.text)
    }
}

extension HiveInspect4VC {
    @IBAction private func onBtnAddAHiveAction(_ sender : UIButton) {
        self.vibrate()
        updateDataAndPush()
    }

    @IBAction private func onBtnSettingsAction(_ sender : UIButton) {
        self.vibrate()
        let mainViewControllerVC = self.navigationController?.viewControllers.first(where: { (viewcontroller) -> Bool in
            return viewcontroller is SettingsVC
        })
        if let mainViewControllerVC = mainViewControllerVC {
            navigationController?.popToViewController(mainViewControllerVC, animated: true)
        }else {
            navigationController?.popToRootViewController(animated: true)
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "SettingsVC") as! SettingsVC
            self.navigationController?.pushViewController(dvc, animated: true)
        }
    }
}

extension HiveInspect4VC : FlexibleSteppedProgressBarDelegate {
    func setupProgressBar() {
        progressBar = FlexibleSteppedProgressBar()
        progressBar.translatesAutoresizingMaskIntoConstraints = false
        self.view.addSubview(progressBar)

        let horizontalConstraint = progressBar.centerXAnchor.constraint(equalTo: self.view.centerXAnchor)
        let statusBarHeight = UIApplication.shared.statusBarFrame.size.height
        let navigationBarHeight = self.navigationController!.navigationBar.frame.height
        let verticalConstraint = progressBar.topAnchor.constraint(
            equalTo: view.topAnchor,
            constant: statusBarHeight + navigationBarHeight
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
        progressBar.completedTillIndex = 4
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
