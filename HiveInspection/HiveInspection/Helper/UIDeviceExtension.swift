//
//  UIDeviceExtension.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 24/08/23.
//

import UIKit
import AudioToolbox

extension UIViewController {
    func vibrate() {
        UIImpactFeedbackGenerator(style: .medium).impactOccurred()
    }
}
