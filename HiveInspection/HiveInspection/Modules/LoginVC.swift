//
//  LoginVC.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 24/08/23.
//

import UIKit

class LoginVC : UIViewController {
    @IBOutlet weak var hiveImgVerticalConstraint : NSLayoutConstraint!
    @IBOutlet weak var hiveImageView : UIImageView!
    @IBOutlet weak var lblTitleOutlet : UILabel!
    @IBOutlet weak var lblDescriptionOutlet : UILabel!
    @IBOutlet weak var onBtnLoginOutlet : LetsButton!
    @IBOutlet weak var onBtnSignUpOutlet : LetsButton!
    
    override func loadView() {
        super.loadView()
        setupUI()
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        animateUI()
    }
}

extension LoginVC {
    private func setupUI() {
        func setupInitialValues() {
            onBtnLoginOutlet.alpha = 0
            onBtnSignUpOutlet.alpha = 0
            lblTitleOutlet.alpha = 0
            lblDescriptionOutlet.alpha = 0
        }
        func setupLoginButton() {
            onBtnLoginOutlet.setTitle("Login", for: .normal)
            onBtnLoginOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnLoginOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnLoginOutlet.cornerRadius = onBtnSignUpOutlet.frame.height / 2
            onBtnLoginOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        func setupSignUpButton() {
            onBtnSignUpOutlet.setTitle("Create Account", for: .normal)
            onBtnSignUpOutlet.setTitleColor(UIColor(named: HiveColor.ThemeBlue.rawValue), for: .normal)
            onBtnSignUpOutlet.cornerRadius = onBtnSignUpOutlet.frame.height / 2
            onBtnSignUpOutlet.borderWidth = 1.5
            onBtnSignUpOutlet.borderColor = UIColor(named: HiveColor.ThemeBlue.rawValue)!
            onBtnSignUpOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        setupInitialValues()
        setupLoginButton()
        setupSignUpButton()
    }
    
    private func animateUI() {
        func setTopConstraintOfImage() {
            let topHeight = (SCREEN_HEIGHT/2) - (self.hiveImageView.frame.height / 2) - 40
            self.hiveImgVerticalConstraint.constant = -topHeight
            UIView.animate(withDuration: 0.8, animations: {
                self.view.layoutIfNeeded()
            }, completion: { finished in
                self.view.layoutIfNeeded()
                showWithAlpha1()
            })
        }
        
        func showWithAlpha1() {
            UIView.animate(withDuration: 0.5) {
                self.onBtnLoginOutlet.alpha = 1
                self.onBtnSignUpOutlet.alpha = 1
                self.lblTitleOutlet.alpha = 1
                self.lblDescriptionOutlet.alpha = 1
            }
        }
        
        setTopConstraintOfImage()
    }
}

extension LoginVC {
    @IBAction private func onBtnLoginAction(_ sender: UIButton){
        self.vibrate()
    }
    
    @IBAction private func onBtnSignUpAction(_ sender: UIButton){
        self.vibrate()
    }
}
