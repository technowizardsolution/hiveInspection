//
//  ChangePasswordVC.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 28/08/23.
//

import UIKit

class ChangePasswordVC : UIViewController {
    @IBOutlet private weak var txtOldPasswordOutlet : UITextField!
    @IBOutlet private weak var txtNewPasswordOutlet : UITextField!
    @IBOutlet private weak var txtConfirmPasswordOutlet : UITextField!
    @IBOutlet private weak var onBtnSubmitOutlet : LetsButton!

    var changePasswordVM : ChangePasswordViewModel?
    
    override func viewDidLoad() {
        super.viewDidLoad()
        setupButtons()
        showTransparentNavigationBar()
        closeButton()
        changePasswordVM = ChangePasswordViewModel()
        changePasswordVM?.delegate = self
    }

    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        showTransparentNavigationBar()
        closeButton()
    }
}

extension ChangePasswordVC : ChangePasswordResponse {
    func getChangePasswordResponse(_ model: LoginModel) {
        if (model.status ?? 0) == 1 {
            navigationController?.popViewController(animated: true)
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

extension ChangePasswordVC {
    private func setupButtons() {
        func setupSubmitButton() {
            onBtnSubmitOutlet.setTitle("Submit", for: .normal)
            onBtnSubmitOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnSubmitOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnSubmitOutlet.cornerRadius = onBtnSubmitOutlet.frame.height / 2
            onBtnSubmitOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        setupSubmitButton()
    }
}

extension ChangePasswordVC {
    @IBAction private func onBtnSubmitAction(_ sender : UIButton) {
        self.vibrate()
        var validationModel = ChangePasswordValidation()
        validationModel.oldPassword = txtOldPasswordOutlet.text ?? ""
        validationModel.newPassword = txtNewPasswordOutlet.text ?? ""
        validationModel.newConfirmPassword = txtConfirmPasswordOutlet.text ?? ""
        let validated = checkChangePasswordValidation(validationModel: validationModel)
        if validated.0 {
            let param : [String:Any] = ["data": [
                    "old_password": validationModel.oldPassword,
                    "new_password": validationModel.newPassword
                ]]
            changePasswordVM?.callAPI(param)
        }else {
            UIAlertController.actionWith(andMessage: validated.1, getStyle: .alert,controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in }
        }
    }
    
    @IBAction private func onBtnSettingsAction(_ sender : UIButton) {
        self.vibrate()
        let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "SettingsVC") as! SettingsVC
        navigationController?.pushViewController(dvc, animated: true)
    }
}

extension ChangePasswordVC : UITextFieldDelegate {
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        return true
    }
}
