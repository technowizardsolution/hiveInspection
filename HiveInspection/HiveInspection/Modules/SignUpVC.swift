//
//  SignUpVC.swift
//  HiveInspection
//
//  Created by LN-iMAC-004 on 26/08/23.
//

import UIKit

class SignUpVC : UIViewController {
    @IBOutlet private weak var txtEmailOutlet : UITextField!
    @IBOutlet private weak var txtPasswordOutlet : UITextField!
    @IBOutlet private weak var onBtnSignUpOutlet : LetsButton!

    override func viewDidLoad() {
        super.viewDidLoad()
        setupButtons()
        txtEmailOutlet.delegate = self
        txtPasswordOutlet.delegate = self
        showTransparentNavigationBar()
        closeButton()
    }

    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        showTransparentNavigationBar()
        closeButton()
    }
}

extension SignUpVC {
    private func setupButtons() {
        func setupEmailPassword() {
            txtEmailOutlet.keyboardType = .emailAddress
            txtPasswordOutlet.keyboardType = .default
        }
        func setupSignUpButton() {
            onBtnSignUpOutlet.setTitle("Sign Up", for: .normal)
            onBtnSignUpOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnSignUpOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnSignUpOutlet.cornerRadius = onBtnSignUpOutlet.frame.height / 2
            onBtnSignUpOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        setupSignUpButton()
    }
}

extension SignUpVC {
    @IBAction private func onBtnSignUpAction(_ sender : UIButton) {
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
}
extension SignUpVC : UITextFieldDelegate {
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        if textField == txtEmailOutlet {
            txtPasswordOutlet.becomeFirstResponder()
        }else {
            txtPasswordOutlet.resignFirstResponder()
            onBtnSignUpAction(UIButton())
        }
        return true
    }
}
