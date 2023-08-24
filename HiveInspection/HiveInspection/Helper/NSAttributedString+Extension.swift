//
//  NSAttributedString+Extension.swift
//  Pods
//
//  Created by Lokesh on 17/05/16.
//
//

import Foundation
import UIKit

public extension NSAttributedString {
    
    class func HTMLString(_ HTMLString: String) throws -> NSAttributedString?{
        let data = HTMLString.data(using: String.Encoding.utf8, allowLossyConversion: false)
        
        let opt = [NSAttributedString.DocumentReadingOptionKey.documentType: NSAttributedString.DocumentType.html,
                   NSAttributedString.DocumentReadingOptionKey.characterEncoding: String.Encoding.utf8.rawValue] as [NSAttributedString.DocumentReadingOptionKey : Any]
        do {
            return try NSAttributedString(data: data!, options: opt, documentAttributes: nil)
        } catch  {
            NSException(name: NSExceptionName(rawValue: "Html"), reason: "Not convert", userInfo: nil).raise()
        }
        return nil
    }
    class func attributedString(_ string: String, withFont font: UIFont) -> NSAttributedString {
        let attributedString = NSMutableAttributedString(string: string)
        attributedString.addAttribute(NSAttributedString.Key.font, value: font, range: NSMakeRange(0, attributedString.length))
        return attributedString
    }
}
