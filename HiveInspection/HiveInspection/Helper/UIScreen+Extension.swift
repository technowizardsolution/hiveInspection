//
//  UIScreen+Extension.swift
//  Pods
//
//  Created by Lokesh on 17/05/16.
//
//

import Foundation
import UIKit

public extension UIScreen {
    
    class var size: CGSize {
        return UIScreen.main.bounds.size
    }
    
    class var width: CGFloat {
        return size.width
    }
    
    class var height: CGFloat {
        return size.height
    }
}
