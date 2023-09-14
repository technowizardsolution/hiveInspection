//
//  SettingsVC.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 28/08/23.
//

import UIKit

class CellT_Settings : UITableViewCell {
    @IBOutlet weak var imgDetailView : UIImageView!
    @IBOutlet weak var lblVersionOutlet : UILabel!
    @IBOutlet weak var lblTitleOutlet : UILabel!
    @IBOutlet weak var switchNotificationOutlet : UISwitch!
    var completionSwitchChanged : (UISwitch) -> () = { _ in }
    @IBAction func onSwitchNotificationAction(_ sender: UISwitch) {
        completionSwitchChanged(sender)
    }
}

class SettingsVC : UIViewController {
    @IBOutlet private weak var tableview : UITableView!
    @IBOutlet weak var onBtnStartInspectingOutlet : LetsButton!
    var getSettingsData : [SettingsData]?
    
    override func viewDidLoad() {
        super.viewDidLoad()
        self.title = "Settings"
        tableview.dataSource = self
        tableview.delegate = self
        setupSettingsData()
        setupButtons()
        showTransparentNavigationBar()
        closeButton()
    }

    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        showTransparentNavigationBar()
        closeButton()
    }
}

extension SettingsVC {
    private func setupSettingsData() {
        defer {
            tableview.reloadData()
        }
        getSettingsData = []
        getSettingsData?.append(SettingsData(title: "Add a Hive", type: .detail))
//        getSettingsData?.append(SettingsData(title: "Edit a Hive", type: .detail))
        getSettingsData?.append(SettingsData(title: "Notifications", type: ._switch))
        getSettingsData?.append(SettingsData(title: "About Us", type: .detail))
        getSettingsData?.append(SettingsData(title: "Subscription", type: .detail))
        getSettingsData?.append(SettingsData(title: "Change Password", type: .detail))
        getSettingsData?.append(SettingsData(title: "Terms & Conditions", type: .detail))
        getSettingsData?.append(SettingsData(title: "Privacy Policy", type: .detail))
        getSettingsData?.append(SettingsData(title: "App Version", type: .version))
        getSettingsData?.append(SettingsData(title: "Logout", type: .none))
        getSettingsData?.append(SettingsData(title: "Delete Account", type: .none))
    }
    
    private func setupButtons() {
        func setupStartInspectingButton() {
            onBtnStartInspectingOutlet.isHidden = true
            onBtnStartInspectingOutlet.setTitle("Start inspecting!", for: .normal)
            onBtnStartInspectingOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnStartInspectingOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnStartInspectingOutlet.cornerRadius = onBtnStartInspectingOutlet.frame.height / 2
            onBtnStartInspectingOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        setupStartInspectingButton()
    }
}

extension SettingsVC : UITableViewDataSource, UITableViewDelegate {
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return getSettingsData?.count ?? 0
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        guard let cell = tableview.dequeueReusableCell(withIdentifier: "CellT_Settings") as? CellT_Settings else { return UITableViewCell() }
        cell.backgroundColor = indexPath.row == 0 ? UIColor(red: 0.922, green: 0.934, blue: 0.97, alpha: 1) : .clear
        let item = getSettingsData?[indexPath.row]
        cell.imgDetailView.isHidden = !(item?.type == .detail)
        cell.switchNotificationOutlet.isHidden = !(item?.type == ._switch)
        cell.lblVersionOutlet.isHidden = !(item?.type == .version)
        cell.lblTitleOutlet.text = item?.title
        cell.lblVersionOutlet.text = "V \(UIApplication.shared.version ?? "1.0")"
        cell.completionSwitchChanged = { sender in
            //Call notification Api
        }
        return cell
    }
    
    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        return 50
    }

    func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) {
        let item = getSettingsData?[indexPath.row]
        switch indexPath.row {
        case 0:
            //Add a Hive
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "HiveSetupVC") as! HiveSetupVC
            dvc.showBackbutton = true
            navigationController?.pushViewController(dvc, animated: true)
            break
        case 2:
            //About Us
            self.vibrate()
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "CMSVC") as! CMSVC
            dvc.cms = .aboutus
            dvc.getTitle = item?.title ?? ""
            navigationController?.pushViewController(dvc, animated: true)
            break
        case 4:
            //Change Password
            self.vibrate()
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "ChangePasswordVC") as! ChangePasswordVC
            navigationController?.pushViewController(dvc, animated: true)
            break
        case 5:
            //Terms & Conditions
            self.vibrate()
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "CMSVC") as! CMSVC
            dvc.cms = .termsandcondition
            dvc.getTitle = item?.title ?? ""
            navigationController?.pushViewController(dvc, animated: true)
            break
        case 6:
            //Privacy Policy
            self.vibrate()
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "CMSVC") as! CMSVC
            dvc.cms = .privacypolicy
            dvc.getTitle = item?.title ?? ""
            navigationController?.pushViewController(dvc, animated: true)
            break
        case 8:
            //Logout
            self.vibrate()
            UIAlertController.actionWith(andMessage: "Are you sure you want to logout", getStyle: .actionSheet, controller : self, buttons: [UIAlertController.actionTitleStyle(title: "Yes", style: .default),UIAlertController.actionTitleStyle(title: "Cancel", style: .cancel)]) { btn in
                self.vibrate()
                if btn == "Yes" {
                    //navigate to login
                    Constants.clearDefaults()
                    let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "LoginVC") as! LoginVC
                    appDelegate.window?.switchRootViewController(to: dvc)
                }
            }
            break
        case 9:
            //Delete Account
            self.vibrate()
            UIAlertController.actionWith(andMessage: "Are you sure you want to delete your account?", getStyle: .actionSheet, controller : self, buttons: [UIAlertController.actionTitleStyle(title: "Yes", style: .destructive),UIAlertController.actionTitleStyle(title: "Cancel", style: .cancel)]) { btn in
                self.vibrate()
                if btn == "Yes" {
                    //navigate to login
                    Constants.clearDefaults()
                    let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "LoginVC") as! LoginVC
                    appDelegate.window?.switchRootViewController(to: dvc)
                }
            }
            break
        default:
            break
        }
    }
}