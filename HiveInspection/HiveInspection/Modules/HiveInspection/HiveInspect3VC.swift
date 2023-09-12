//
//  HiveInspect3VC.swift
//  HiveInspection
//
//  Created by LN-iMAC-004 on 31/08/23.
//

import UIKit

import FlexibleSteppedProgressBar

class CellT_HiveInspect3 : UITableViewCell {
    @IBOutlet weak var onSwitchWithTextOutlet : UISwitch!
    @IBOutlet weak var lblTitleOutlet : UILabel!
    @IBOutlet weak var bottomBorderOutlet : UIView!
    @IBOutlet weak var txtHiveDataOutlet : UITextField!
    var completionOnSwitchWithTextChanged : ((UISwitch) -> ())?

    @IBAction func onSwitchWithTextChangeAction(_ sender: UISwitch) {
        completionOnSwitchWithTextChanged?(sender)
    }
}

class HiveInspect3VC : UIViewController {
    @IBOutlet private weak var tableview : UITableView!
    @IBOutlet weak var onBtnAddAHiveOutlet : LetsButton!
    @IBOutlet weak var onBtnNextOutlet : LetsButton!
    var selectedHiveNumber = ""
    var hiveId = ""
    var getHiveInspectData : [HiveInspectData]?
    var getTotalHiveInspectData : [HiveInspectData]?
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
    
    override func gotoBack() {
        super.gotoBack()
        navigationController?.popToRootViewController(animated: true)
    }
}

extension HiveInspect3VC : UITextFieldDelegate {
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        getHiveInspectData?[textField.tag].selectedTitle = (textField.text ?? "") + string
        let allowedCharacters = CharacterSet.decimalDigits
        let characterSet = CharacterSet(charactersIn: string)
        return ((textField.text ?? "") + string).count <= 5 && allowedCharacters.isSuperset(of: characterSet)
    }
}

extension HiveInspect3VC : UITableViewDataSource, UITableViewDelegate {
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return getHiveInspectData?.count ?? 0
    }

    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        guard let cell = tableView.dequeueReusableCell(withIdentifier: "CellT_HiveInspect3", for: indexPath) as? CellT_HiveInspect3 else { return UITableViewCell() }
        if let itemData = getHiveInspectData {
            let item = itemData[indexPath.row]
            cell.lblTitleOutlet.text = item.title
            cell.onSwitchWithTextOutlet.isHidden = !(item.type == ._switchWithText)
            cell.onSwitchWithTextOutlet.layerCornerRadius = cell.onSwitchWithTextOutlet.height / 2
            cell.txtHiveDataOutlet.tag = indexPath.row
            cell.txtHiveDataOutlet.delegate = self
            cell.txtHiveDataOutlet.text = getHiveInspectData?[indexPath.row].selectedTitle
            if item.type == ._switchWithText {
                cell.txtHiveDataOutlet.isHidden = !(self.getHiveInspectData?[indexPath.row].isSwitchWithTextOn ?? false)
                cell.bottomBorderOutlet.isHidden = !(self.getHiveInspectData?[indexPath.row].isSwitchWithTextOn ?? false)
            }else {
                cell.txtHiveDataOutlet.isHidden = false
                cell.bottomBorderOutlet.isHidden = false
            }
            cell.completionOnSwitchWithTextChanged = { _switch in
                self.getHiveInspectData?[indexPath.row].isSwitchWithTextOn = _switch.isOn
                cell.txtHiveDataOutlet.isHidden = !(self.getHiveInspectData?[indexPath.row].isSwitchWithTextOn ?? false)
                cell.bottomBorderOutlet.isHidden = !(self.getHiveInspectData?[indexPath.row].isSwitchWithTextOn ?? false)
                cell.layoutSubviews()
            }
        }
        return cell
    }

    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        return 60
    }
}

extension HiveInspect3VC {
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
        getHiveInspectData?.append(HiveInspectData(title: "Frames of Bees", type: .text))
        getHiveInspectData?.append(HiveInspectData(title: "Frames of Brood", type: .text))
        getHiveInspectData?.append(HiveInspectData(title: "Frames of Honey", type: .text))
        getHiveInspectData?.append(HiveInspectData(title: "Frames of Pollen", type: .text))
        getHiveInspectData?.append(HiveInspectData(title: "Honey Supers", type: ._switchWithText))
        getHiveInspectData?.append(HiveInspectData(title: "Add Supers", type: ._switchWithText))
        getHiveInspectData?.append(HiveInspectData(title: "Weigh Super 3", type: ._switchWithText))
        getHiveInspectData?.append(HiveInspectData(title: "Weigh Super 2", type: ._switchWithText))
        getHiveInspectData?.append(HiveInspectData(title: "Weigh Super 1", type: ._switchWithText))
        getHiveInspectData?.append(HiveInspectData(title: "Weigh Brood 3", type: ._switchWithText))
        getHiveInspectData?.append(HiveInspectData(title: "Weigh Brood 2", type: ._switchWithText))
        getHiveInspectData?.append(HiveInspectData(title: "Weigh Brood 1", type: ._switchWithText))
        getHiveInspectData?.append(HiveInspectData(title: "Prep for extraction", type: ._switchWithText))
    }
}

extension HiveInspect3VC {
    @IBAction private func onBtnNextAction(_ sender : UIButton) {
        self.vibrate()
        let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "HiveInspect4VC") as! HiveInspect4VC
        dvc.selectedHiveNumber = selectedHiveNumber
        dvc.hiveId = self.hiveId
        getTotalHiveInspectData?.append(contentsOf: getHiveInspectData ?? [])
        dvc.getTotalHiveInspectData = getTotalHiveInspectData
        navigationController?.pushViewController(dvc, animated: true)
    }

    @IBAction private func onBtnAddAHiveAction(_ sender : UIButton) {
        self.vibrate()
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

extension HiveInspect3VC : FlexibleSteppedProgressBarDelegate {
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
        progressBar.completedTillIndex = 3
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
