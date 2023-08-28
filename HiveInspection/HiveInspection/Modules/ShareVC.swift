//
//  ShareVC.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 28/08/23.
//

import UIKit

class ShareVC : UIViewController {
    @IBOutlet weak var onBtnSubmitOutlet : LetsButton!
    @IBOutlet weak var onBtnStartInspectingOutlet : LetsButton!
    override func viewDidLoad() {
        super.viewDidLoad()
        setupButtons()
    }
}

extension ShareVC {
    private func setupButtons() {
        func setupSubmitButton() {
            onBtnSubmitOutlet.setTitle("Submit", for: .normal)
            onBtnSubmitOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnSubmitOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnSubmitOutlet.cornerRadius = onBtnSubmitOutlet.frame.height / 2
            onBtnSubmitOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        func setupStartInspectingButton() {
            onBtnStartInspectingOutlet.setTitle("Start Inspecting!", for: .normal)
            onBtnStartInspectingOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnStartInspectingOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnStartInspectingOutlet.cornerRadius = onBtnStartInspectingOutlet.frame.height / 2
            onBtnStartInspectingOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        setupSubmitButton()
        setupStartInspectingButton()
    }
}

extension ShareVC {
    @IBAction private func onBtnSubmitAction(_ sender : LetsButton) {
        self.vibrate()
    }
    
    @IBAction private func onBtnStartInspectingAction(_ sender : LetsButton) {
        self.vibrate()
    }
    
    @IBAction private func onBtnShareAction(_ sender : UIButton) {
        self.vibrate()
        let items = [URL(string: "https://www.apple.com")!]
        let ac = UIActivityViewController(activityItems: items, applicationActivities: nil)
        present(ac, animated: true)
    }
    
    @IBAction private func onBtnSettingsAction(_ sender : UIButton) {
        self.vibrate()
        let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "SettingsVC") as! SettingsVC
        navigationController?.pushViewController(dvc, animated: true)
    }
}
