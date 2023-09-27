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
    var profileVM : ProfileViewModel?
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
        profileVM = ProfileViewModel()
        profileVM?.delegate = self
        profileVM?.callAPI()
    }
}

extension SettingsVC : ProfileResponse {
    func updateNotificationResponse(_ model: SignUpModel) {
        profileVM?.callAPI()
    }
    
    func getProfileResponse(_ model: ProfileModel) {
        self.tableview.reloadData()
    }
    
    func failureResponse(_ error: String) { }
}

extension SettingsVC {
    private func setupSettingsData() {
        defer {
            tableview.reloadData()
        }
        getSettingsData = []
        getSettingsData?.append(SettingsData(title: settingTitle.AddaHive.rawValue, type: .detail))
//        getSettingsData?.append(SettingsData(title: "Edit a Hive", type: .detail))
        getSettingsData?.append(SettingsData(title: settingTitle.Notifications.rawValue, type: ._switch))
        getSettingsData?.append(SettingsData(title: settingTitle.AboutUs.rawValue, type: .detail))
//        getSettingsData?.append(SettingsData(title: "Subscription", type: .detail))
        if Constants.isSocialLogin() == false {
            getSettingsData?.append(SettingsData(title: settingTitle.ChangePassword.rawValue, type: .detail))
        }
        getSettingsData?.append(SettingsData(title: settingTitle.TermsConditions.rawValue, type: .detail))
        getSettingsData?.append(SettingsData(title: settingTitle.PrivacyPolicy.rawValue, type: .detail))
        getSettingsData?.append(SettingsData(title: settingTitle.AppVersion.rawValue, type: .version))
        getSettingsData?.append(SettingsData(title: settingTitle.Logout.rawValue, type: .none))
        getSettingsData?.append(SettingsData(title: settingTitle.DeleteAccount.rawValue, type: .none))
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
        if profileVM != nil, profileVM?.profileData != nil {
            cell.switchNotificationOutlet.isOn = (profileVM?.profileData?.data?.notificationStatus ?? "") == "1"
        }else {
            cell.switchNotificationOutlet.isOn = false
        }
        cell.completionSwitchChanged = { sender in
            let param : [String : Any] = ["data":["notification_status":sender.isOn ? "1" : "0"]]
            self.profileVM?.callNotificationUpdateAPI(param: param)
        }
        return cell
    }
    
    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        return 50
    }

    func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) {
        let item = getSettingsData?[indexPath.row]
        switch item?.title {
        case settingTitle.AddaHive.rawValue:
            //Add a Hive
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "HiveSetupVC") as! HiveSetupVC
            dvc.showBackbutton = true
            navigationController?.pushViewController(dvc, animated: true)
            break
        case settingTitle.AboutUs.rawValue:
            //About Us
            self.vibrate()
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "CMSVC") as! CMSVC
            dvc.cms = .aboutus
            dvc.getTitle = item?.title ?? ""
            navigationController?.pushViewController(dvc, animated: true)
            break
        case settingTitle.ChangePassword.rawValue:
            //Change Password
            self.vibrate()
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "ChangePasswordVC") as! ChangePasswordVC
            navigationController?.pushViewController(dvc, animated: true)
            break
        case settingTitle.TermsConditions.rawValue:
            //Terms & Conditions
            self.vibrate()
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "CMSVC") as! CMSVC
            dvc.cms = .termsandcondition
            dvc.getTitle = item?.title ?? ""
            navigationController?.pushViewController(dvc, animated: true)
            break
        case settingTitle.PrivacyPolicy.rawValue:
            //Privacy Policy
            self.vibrate()
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "CMSVC") as! CMSVC
            dvc.cms = .privacypolicy
            dvc.getTitle = item?.title ?? ""
            navigationController?.pushViewController(dvc, animated: true)
            break
        case settingTitle.Logout.rawValue:
            //Logout
            self.vibrate()
            UIAlertController.actionWith(andMessage: "Are you sure you want to logout", getStyle: .actionSheet, controller : self, buttons: [UIAlertController.actionTitleStyle(title: "Yes", style: .destructive),UIAlertController.actionTitleStyle(title: "Cancel", style: .cancel)]) { btn in
                self.vibrate()
                if btn == "Yes" {
                    //navigate to login
                    Constants.clearDefaults()
                    let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "LoginVC") as! LoginVC
                    appDelegate.window?.switchRootViewController(to: dvc)
                }
            }
            break
        case settingTitle.DeleteAccount.rawValue:
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
