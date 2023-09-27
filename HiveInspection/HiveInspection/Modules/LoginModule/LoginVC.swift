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
    
    var loginVM : LoginViewModel? = nil
    
    override func viewDidLoad() {
        super.viewDidLoad()
        setupButtons()
        showTransparentNavigationBar()
        closeButton()
        txtEmailOutlet.delegate = self
        txtPasswordOutlet.delegate = self
        loginVM = LoginViewModel()
        loginVM?.delegate = self
//        if UIApplication.shared.inferredEnvironment == .debug {
//            txtEmailOutlet.text = "jhon@gmail.com"
//            txtPasswordOutlet.text = "Jhon@123"
//        }
    }
    
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        showTransparentNavigationBar()
        closeButton()
    }
}

extension LoginVC : LoginResponse {
    func getLoginResponse(_ model: LoginModel) {
        if (model.status ?? 1) == 1, let data = model.data {
            UserDefaults.standard.set(data.token ?? "", forKey: "token")
            UserDefaults.standard.set(data.id?.string ?? "" , forKey: "UserId")
            let dvc : HiveListVC = mainStoryBoard.instantiateViewController(withIdentifier: "HiveListVC") as! HiveListVC
            let navVC : UINavigationController = UINavigationController(rootViewController: dvc)
            navVC.showColoredNavigationBar(.white)
            appDelegate.window?.switchRootViewController(to: navVC)
        }else {
            UIAlertController.actionWith(andMessage: model.message ?? "", getStyle: .alert,controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in }
        }
    }
    
    func failureResponse(_ error: String) {
        print(error)
    }
    
    func getForgotPasswordResponse(_ model: ForgotPasswordModel) {
        UIAlertController.actionWith(andMessage: model.message ?? "", getStyle: .alert,controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in }
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
            onBtnSignInOutlet.cornerRadius = onBtnSignInOutlet.frame.height / 2
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
            let param : [String:Any] = ["data": ["email":txtEmailOutlet.text ?? "", "password":txtPasswordOutlet.text ?? "", "device_type":"1", "device_token": Constants.FCMToken()]]
            loginVM?.callLoginAPI(param)
        }else {
            UIAlertController.actionWith(andMessage: validated.1, getStyle: .alert,controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in }
        }
    }

    @IBAction private func onBtnSignUpAction(_ sender : UIButton) {
        self.vibrate()
        let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "SignUpVC") as! SignUpVC
        navigationController?.pushViewController(dvc, animated: true)
    }

    @IBAction private func onBtnForgotPasswordAction(_ sender : UIButton) {
        self.vibrate()
        addAlertController()
    }

    @IBAction private func onBtnLoginWithFacebookAction(_ sender : UIButton) {
        self.vibrate()
        LoginWithFacebook.shared.loginWithFacebook { facebookData in
            print(facebookData)
//            var loginValidation = LoginValidation()
//            loginValidation.email = facebookData?.email ?? ""
//            let validated = checkLoginValidation(validationModel: loginValidation, isSocial: true)
//            if validated.0 {
            let param : [String:Any] = ["data": [
                "first_name": facebookData?.name,
                "social_provider":"facebook",
                "social_provider_id":facebookData?.FBId,
                "device_type":"1",
                "device_token": Constants.FCMToken()]]
            self.loginVM?.callLoginAPI(param, isSocial: true)
//            }else {
//                UIAlertController.actionWith(andMessage: validated.1, getStyle: .alert,controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in }
//            }
        }
    }

    @IBAction private func onBtnLoginWithGoogleAction(_ sender : UIButton) {
        self.vibrate()
        LoginWithGoogle.shared.loginWithGoogle { user in
            print(user)
            let param : [String:Any] = ["data": [
                "first_name": user?.profile?.name,
                "social_provider":"google",
                "social_provider_id":user?.userID,
                "device_type":"1",
                "device_token": Constants.FCMToken()]]
            self.loginVM?.callLoginAPI(param, isSocial: true)
        }
    }

    @IBAction private func onBtnLoginWithAppleAction(_ sender : UIButton) {
        self.vibrate()
        LoginWithApple.shared.loginWithApple { credentials in
            print(credentials?.fullName ?? "")
            if KeychainItem.currentUserIdentifier != nil {
                let param : [String:Any] = ["data": [
                    "first_name": KeychainItem.currentUserName,
                    "social_provider":"apple",
                    "social_provider_id":KeychainItem.currentUserIdentifier,
                    "device_type":"1",
                    "device_token": Constants.FCMToken()]]
                self.loginVM?.callLoginAPI(param, isSocial: true)
            }else {
                let param : [String:Any] = ["data": [
                    "first_name": credentials?.fullName ?? "",
                    "social_provider":"apple",
                    "social_provider_id":credentials?.user ?? "",
                    "device_type":"1",
                    "device_token": Constants.FCMToken()]]
                self.loginVM?.callLoginAPI(param, isSocial: true)
            }
        }
    }
    
    func addAlertController() {
        let alertController: UIAlertController = UIAlertController(title: UIApplication.shared.displayName, message: "Please enter your email", preferredStyle: .alert)

        //cancel button
        let cancelAction: UIAlertAction = UIAlertAction(title: "Cancel", style: .cancel) { action -> Void in
            //cancel code
        }
        alertController.addAction(cancelAction)

        //Create an optional action
        let nextAction: UIAlertAction = UIAlertAction(title: "Submit", style: .default) { action -> Void in
            if let text = alertController.textFields?.first?.text {
                if validateEmailWithString(text) {
                    UIAlertController.actionWith(andMessage: popupMessages.correctEmail.rawValue, getStyle: .alert, controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in
                        self.addAlertController()
                    }
                }else {
                    let param : [String:Any] = ["data": ["email" : text]]
                    self.loginVM?.callForgotPasswordAPI(param)
                }
            }
        }
        alertController.addAction(nextAction)

        //Add text field
        alertController.addTextField { (textField) -> Void in
            textField.textColor = UIColor.black
        }
        //Present the AlertController
        present(alertController, animated: true)
    }
}

extension LoginVC : UITextFieldDelegate {
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        if textField == txtEmailOutlet {
            txtPasswordOutlet.becomeFirstResponder()
        }else {
            txtPasswordOutlet.resignFirstResponder()
            onBtnLoginAction(UIButton())
        }
        return true
    }
}
