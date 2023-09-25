//
//  UIAlertController + extension.swift
//  AutoVerify
//
//  Created by syed fazal abbas on 15/12/22.
//  Copyright © 2022 letsnurture. All rights reserved.
//

import UIKit

extension UIAlertController {
    struct actionTitleStyle {
        var title : String = ""
        var style : UIAlertAction.Style = .default
    }

    /// Action with function is to Help you for actionsheet and alert.
    /// If your want to show alert or action sheet from viewdidload, use viewdidappear instead.
    /// - Parameters:
    ///   - Title: Add your Title for UIAlertController Title
    ///   - Message: Add your Message for UIAlertController Message
    ///   - getStyle: Select your style i.e alert or actionSheet it work for both
    ///   - controller: give your presentation viewController so it can present your alert
    ///   - buttons: Add your buttons name so we can add buttons with given name
    ///   - comp: It will return the block of button action with button name, you just need to compare your button name string with the given completionBlock
    class func actionWith(_ title : String = UIApplication.shared.displayName ?? "" ,andMessage Message : String , getStyle : UIAlertController.Style, controller : UIViewController = appDelegate.window?.rootViewController ?? UIViewController(), buttons : [actionTitleStyle], completionBlock : @escaping(String) -> ()) {
        let alert = self.init(title: title, message: Message, preferredStyle: UIDevice.current.userInterfaceIdiom == .pad ? .alert : getStyle)
        alert.modalPresentationStyle = .popover
        for button in buttons {
            let btnAction = UIAlertAction(title: button.title, style: button.style) { (action) in
                completionBlock(button.title)
            }
            alert.addAction(btnAction)
        }
        controller.present(alert, animated: true, completion: nil)
    }
}
