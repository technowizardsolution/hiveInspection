//
//  RateAppVC.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 28/08/23.
//

import UIKit

class RateAppVC : UIViewController {
    @IBOutlet weak var onBtnSubmitOutlet : LetsButton!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        setupButtons()
    }
}
extension RateAppVC {
    private func setupButtons() {
        func setupSubmitButton() {
            onBtnSubmitOutlet.setTitle("Next", for: .normal)
            onBtnSubmitOutlet.backgroundColor = UIColor(named: HiveColor.ThemeYellow.rawValue)
            onBtnSubmitOutlet.setTitleColor(UIColor.black, for: .normal)
            onBtnSubmitOutlet.cornerRadius = onBtnSubmitOutlet.frame.height / 2
            onBtnSubmitOutlet.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)
        }
        setupSubmitButton()
    }
}

extension RateAppVC {
    @IBAction private func onBtnSubmitAction(_ sender : LetsButton) {
        self.vibrate()
        let dvc = mainStoryBoard.instantiateViewController(withIdentifier: "ShareVC") as! ShareVC
        navigationController?.pushViewController(dvc, animated: true)
    }
}
