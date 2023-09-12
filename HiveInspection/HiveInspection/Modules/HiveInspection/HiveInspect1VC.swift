//
//  HiveInspect1VC.swift
//  HiveInspection
//
//  Created by LN-iMAC-004 on 28/08/23.
//

import UIKit
import FlexibleSteppedProgressBar

class CellT_HiveInspect : UITableViewCell {
    @IBOutlet weak var onSwitchOutlet : UISwitch!
//    @IBOutlet weak var onSwitchWithTextOutlet : UISwitch!
    @IBOutlet weak var onDatePickerOutlet : UIDatePicker!
    @IBOutlet weak var onBtnDropDownOutlet : UIButton!
    @IBOutlet weak var lblTitleOutlet : UILabel!

    func setPopUpButton(completion : @escaping (String) -> ()) {
        let optionClosure = {(action: UIAction) in
            self.onBtnDropDownOutlet.setTitle(action.title, for: .normal)
            completion(action.title)
        }
        var arrUIAction = [UIAction]()
        for hiveSetupData in 1...10 {
            arrUIAction.append(UIAction(title: hiveSetupData.string, state: .off, handler: optionClosure))
        }
        onBtnDropDownOutlet.menu = UIMenu(children: arrUIAction)
        onBtnDropDownOutlet.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            onBtnDropDownOutlet.changesSelectionAsPrimaryAction = true
        }
    }
    @IBAction func onSwitchChangeAction(_ sender: UISwitch) {

    }
}

class HiveInspect1VC : UIViewController {
    @IBOutlet private weak var tableview : UITableView!
    @IBOutlet weak var onBtnAddAHiveOutlet : LetsButton!
    @IBOutlet weak var onBtnNextOutlet : LetsButton!

    var getHiveInspectData : [HiveInspectData]?
    var progressBar: FlexibleSteppedProgressBar!
    var selectedHiveNumber = "1"
    var hiveId = ""
    
    override func viewDidLoad() {
        super.viewDidLoad()
        self.title = "Hive Number"
        tableview.dataSource = self
        tableview.delegate = self
        setupData()
        setupButtons()
        showTransparentNavigationBar()
        closeButton()
        pullDownButton { selectedString in
            self.selectedHiveNumber = selectedString
        }
        setupProgressBar()
    }

    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        showTransparentNavigationBar()
        closeButton()
        pullDownButton { selectedString in
            self.selectedHiveNumber = selectedString
        }
    }
}

extension HiveInspect1VC : UITableViewDataSource, UITableViewDelegate {
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return getHiveInspectData?.count ?? 0
    }

    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        guard let cell = tableView.dequeueReusableCell(withIdentifier: "CellT_HiveInspect", for: indexPath) as? CellT_HiveInspect else { return UITableViewCell() }
        if let itemData = getHiveInspectData {
            let item = itemData[indexPath.row]
            cell.lblTitleOutlet.text = item.title
            cell.onBtnDropDownOutlet.isHidden = !(item.type == .dropdown)
            cell.onSwitchOutlet.isHidden = !(item.type == ._switch)
            cell.onDatePickerOutlet.isHidden = !(item.type == .date)
            cell.onSwitchOutlet.layerCornerRadius = cell.onSwitchOutlet.height / 2
            cell.setPopUpButton { selectedTitle in
                self.getHiveInspectData?[indexPath.row].selectedTitle = selectedTitle
            }
        }
        return cell
    }

    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        return 60
    }
}

extension HiveInspect1VC {
    private func setupButtons() {
        func setupAddAHiveButton() {
            onBtnAddAHiveOutlet.isHidden = true
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
        getHiveInspectData?.append(HiveInspectData(title: "Date", type: .date))
        getHiveInspectData?.append(HiveInspectData(title: "Normal Hive Condition", type: ._switch))
        getHiveInspectData?.append(HiveInspectData(title: "Saw Queen", type: ._switch))
        getHiveInspectData?.append(HiveInspectData(title: "Queen Marked", type: ._switch))
        getHiveInspectData?.append(HiveInspectData(title: "Eggs Seen", type: ._switch))
        getHiveInspectData?.append(HiveInspectData(title: "Larva Seen", type: ._switch))
        getHiveInspectData?.append(HiveInspectData(title: "Pupa Seen", type: ._switch))
        getHiveInspectData?.append(HiveInspectData(title: "Drone Cells", type: ._switch))
        getHiveInspectData?.append(HiveInspectData(title: "Queen Cells", type: ._switch))
        getHiveInspectData?.append(HiveInspectData(title: "Hive Beetles", type: ._switch))
        getHiveInspectData?.append(HiveInspectData(title: "Wax Moth", type: ._switch))
        getHiveInspectData?.append(HiveInspectData(title: "Noseema", type: ._switch))
        getHiveInspectData?.append(HiveInspectData(title: "Mite Wash", type: ._switch))
        getHiveInspectData?.append(HiveInspectData(title: "Mite Count", type: .dropdown))
    }
    
    func updateDataAndPush() {
        
        func selectDate(_index : Int) {
            if let cell = tableview.cellForRow(at: IndexPath(row: _index, section: 0)) as? CellT_HiveInspect {
                let dateString = cell.onDatePickerOutlet.date.toString("yyyy-MM-dd") ?? ""
                getHiveInspectData?[_index].selectedTitle = dateString
            }else {
                delay(0.2) {
                    selectDate(_index: _index)
                }
            }
        }
        for (_index,inspectData) in (getHiveInspectData ?? []).enumerated() {
            if inspectData.type == ._switch {
                getHiveInspectData?[_index].selectedTitle = inspectData.isSwitchOn ? "1" : "0"
            }else if inspectData.type == .date {
                selectDate(_index: _index)
            }else if inspectData.type == .dropdown {
                if getHiveInspectData?[_index].selectedTitle == "" {
                    getHiveInspectData?[_index].selectedTitle = "1"
                }
            }
        }
        let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "HiveInspect2VC") as! HiveInspect2VC
        dvc.selectedHiveNumber = self.selectedHiveNumber
        dvc.getTotalHiveInspectData = []
        dvc.hiveId = self.hiveId
        dvc.getTotalHiveInspectData = self.getHiveInspectData
        navigationController?.pushViewController(dvc, animated: true)
    }
}

extension HiveInspect1VC {
    @IBAction private func onBtnNextAction(_ sender : UIButton) {
        self.vibrate()
        updateDataAndPush()
    }

//    @IBAction private func onBtnAddAHiveAction(_ sender : UIButton) {
//        self.vibrate()
//    }

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

extension HiveInspect1VC : FlexibleSteppedProgressBarDelegate {
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
        progressBar.completedTillIndex = 1
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
