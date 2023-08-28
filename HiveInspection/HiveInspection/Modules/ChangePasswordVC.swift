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

    override func viewDidLoad() {
        super.viewDidLoad()
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
