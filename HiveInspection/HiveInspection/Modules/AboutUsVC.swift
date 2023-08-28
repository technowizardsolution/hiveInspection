//
//  AboutUsVC.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 28/08/23.
//

import UIKit
import WebKit
class AboutUsVC : UIViewController {
    @IBOutlet weak var onBtnStartInspectingOutlet : LetsButton!
    @IBOutlet weak var wkWebViewOutlet : WKWebView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        showTransparentNavigationBar()
        closeButton()
    }
    
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        showTransparentNavigationBar()
        closeButton()
    }
}
extension AboutUsVC {
    private func setupButtons() {
        func setupStartInspectingButton() {
            onBtnStartInspectingOutlet.setTitle("Start Inspecting!", for: .normal)
            onBtnStartInspectingOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnStartInspectingOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnStartInspectingOutlet.cornerRadius = onBtnStartInspectingOutlet.frame.height / 2
            onBtnStartInspectingOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        setupStartInspectingButton()
    }
}

extension AboutUsVC {
    @IBAction private func onBtnStartInspectingAction(_ sender : LetsButton) {
        self.vibrate()
    }
    
    @IBAction private func onBtnSettingsAction(_ sender : UIButton) {
        self.vibrate()
    }
}
