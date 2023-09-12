//
//  CMSVC.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 28/08/23.
//

import UIKit
import WebKit

class CMSVC : UIViewController {
    @IBOutlet weak var onBtnStartInspectingOutlet : LetsButton!
    @IBOutlet weak var wkWebViewOutlet : WKWebView!
    var getTitle = ""
    var cms : CMSPages? = .aboutus
    var cmsVM : CMSViewModel?
    override func viewDidLoad() {
        super.viewDidLoad()
        showColoredNavigationBar(.white)
        closeButton()
        self.title = getTitle
        cmsVM = CMSViewModel()
        cmsVM?.delegate = self
        let param : [String : Any] = ["data" : ["slug" : cms?.rawValue ?? ""]]
        cmsVM?.callAPI(param)
    }
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        showColoredNavigationBar(.white)
        self.title = getTitle
        closeButton()
    }
}

extension CMSVC : CMSResponse {
    func getCMSResponse(_ model: CMSModel) {
        if (model.status ?? 0) == 1 {
            wkWebViewOutlet.loadHTMLString(model.data?.content ?? "", baseURL: nil)
        }else if (model.status ?? 0) == 2 {
            let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "LoginVC") as! LoginVC
            let navVC : UINavigationController = UINavigationController(rootViewController: dvc)
            navVC.showColoredNavigationBar(.white)
            appDelegate.window?.switchRootViewController(to: navVC)
        }
    }
    
    func failureResponse(_ error: String) {
        UIAlertController.actionWith(andMessage: error, getStyle: .alert, controller: self, buttons: [UIAlertController.actionTitleStyle(title: "OK", style: .default)]) { _ in }
    }
}
extension CMSVC {
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
extension CMSVC {
    @IBAction private func onBtnStartInspectingAction(_ sender : LetsButton) {
        self.vibrate()
    }
    
    @IBAction private func onBtnSettingsAction(_ sender : UIButton) {
        self.vibrate()
    }
}
