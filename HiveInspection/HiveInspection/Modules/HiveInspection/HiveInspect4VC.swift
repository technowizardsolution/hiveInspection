//
//  HiveInspect4VC.swift
//  HiveInspection
//
//  Created by LN-iMAC-004 on 31/08/23.
//

import UIKit
import FlexibleSteppedProgressBar

class CellT_HiveInspect4 : UITableViewCell {
    @IBOutlet weak var onSwitchOutlet : UISwitch!
    @IBOutlet weak var onSwitchWithTextOutlet : UISwitch!
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

    @IBAction func onSwitchWithTextChangeAction(_ sender: UISwitch) {
    }
}

class HiveInspect4VC : UIViewController {
    @IBOutlet private weak var tableview : UITableView!
    @IBOutlet weak var onBtnAddAHiveOutlet : LetsButton!
    @IBOutlet weak var onBtnNextOutlet : LetsButton!
    var selectedHiveNumber = ""
    var getHiveInspectData : [HiveInspectData]?
    var progressBar: FlexibleSteppedProgressBar!

    override func viewDidLoad() {
        super.viewDidLoad()
        self.title = "Hive Number \(selectedHiveNumber)"
        tableview.dataSource = self
        tableview.delegate = self
        setupData()
        setupButtons()
        showTransparentNavigationBar()
        closeButton()
//        pullDownButton { selectedString in
//            print(selectedString)
//        }
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

extension HiveInspect4VC : UITableViewDataSource, UITableViewDelegate {
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return getHiveInspectData?.count ?? 0
    }

    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        guard let cell = tableView.dequeueReusableCell(withIdentifier: "CellT_HiveInspect4", for: indexPath) as? CellT_HiveInspect4 else { return UITableViewCell() }
        if let itemData = getHiveInspectData {
            let item = itemData[indexPath.row]
            cell.lblTitleOutlet.text = item.title
            cell.onBtnDropDownOutlet.isHidden = !(item.type == .dropdown)
            cell.onSwitchOutlet.isHidden = !(item.type == ._switch)
//            cell.onSwitchWithTextOutlet.isHidden = !(item.type == ._switchWithText)
            cell.onDatePickerOutlet.isHidden = !(item.type == .date)
            cell.onSwitchOutlet.layerCornerRadius = cell.onSwitchOutlet.height / 2
            cell.setPopUpButton { selectedTitle in
                print(selectedTitle)
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
}

extension HiveInspect4VC {
    @IBAction private func onBtnNextAction(_ sender : UIButton) {
        self.vibrate()
    }

    @IBAction private func onBtnAddAHiveAction(_ sender : UIButton) {
        self.vibrate()
    }

    @IBAction private func onBtnSettingsAction(_ sender : UIButton) {
        self.vibrate()
        self.navigationController?.popViewController(animated: true)
    }
}

extension HiveInspect4VC : FlexibleSteppedProgressBarDelegate {
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
