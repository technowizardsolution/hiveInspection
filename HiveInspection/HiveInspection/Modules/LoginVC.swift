//
//  LoginVC.swift
//  HiveInspection
//
//  Created by LN-iMAC-004 on 25/08/23.
//

import UIKit

class LoginVC : UIViewController {
    @IBOutlet private weak var txtEmailOutlet : UITextField!
    @IBOutlet private weak var txtPasswordOutlet : UITextField!
    @IBOutlet private weak var onBtnSignInOutlet : LetsButton!
    @IBOutlet private weak var onBtnSignUpOutlet : LetsButton!

    override func viewDidLoad() {
        super.viewDidLoad()
        setupButtons()
    }
}

extension LoginVC {
    private func setupButtons() {
        func setupEmailPassword() {
            txtEmailOutlet.keyboardType = .emailAddress
            txtPasswordOutlet.keyboardType = .default
        }
        func setupLoginButton() {
            onBtnSignInOutlet.setTitle("Login", for: .normal)
            onBtnSignInOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnSignInOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnSignInOutlet.cornerRadius = onBtnSignUpOutlet.frame.height / 2
            onBtnSignInOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        func setupSignUpButton() {
            onBtnSignUpOutlet.setTitle("New User? SIGN UP", for: .normal)
            onBtnSignUpOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnSignUpOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnSignUpOutlet.cornerRadius = onBtnSignUpOutlet.frame.height / 2
            onBtnSignUpOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        setupLoginButton()
        setupSignUpButton()
    }
}

extension LoginVC {
    @IBAction private func onBtnLoginAction(_ sender : UIButton) {
        self.vibrate()
        var loginValidation = LoginValidation()
        loginValidation.email = txtEmailOutlet.text ?? ""
        loginValidation.password = txtPasswordOutlet.text ?? ""
        let validated = checkLoginValidation(validationModel: loginValidation)
        if validated.0 {

        }else {
            UIAlertController.actionWith(andMessage: validated.1, getStyle: .alert,controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in }
        }
    }

    @IBAction private func onBtnSignUpAction(_ sender : UIButton) {
        self.vibrate()
    }

    @IBAction private func onBtnForgotPasswordAction(_ sender : UIButton) {
        self.vibrate()
    }

    @IBAction private func onBtnLoginWithFacebookAction(_ sender : UIButton) {
        self.vibrate()
    }

    @IBAction private func onBtnLoginWithGoogleAction(_ sender : UIButton) {
        self.vibrate()
    }

    @IBAction private func onBtnLoginWithAppleAction(_ sender : UIButton) {
        self.vibrate()
    }
}
