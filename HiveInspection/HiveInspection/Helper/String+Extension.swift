//
//  String+Extension.swift
//  Pods
//
//  Created by Lokesh on 09/05/16.
//
//

import Foundation
import UIKit

// MARK: - String Extension -
extension String {
    var isUsernameString : Bool{
        let invalidCharSet = CharacterSet(charactersIn: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz._1234567890").inverted as CharacterSet
        let filtered : String = self.components(separatedBy: invalidCharSet).joined(separator: "")
        return (self == filtered)
    }
    var isEmailString : Bool{
        let invalidCharSet = CharacterSet(charactersIn: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz._1234567890@").inverted as CharacterSet
        let filtered : String = self.components(separatedBy: invalidCharSet).joined(separator: "")
        return (self == filtered)
    }
    var isCharacterWithSpace : Bool{
        let invalidCharSet = CharacterSet(charactersIn: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ").inverted as CharacterSet
        let filtered : String = self.components(separatedBy: invalidCharSet).joined(separator: "")
        return (self == filtered)
    }
    var isCharacter : Bool{
        let invalidCharSet = CharacterSet(charactersIn: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz").inverted as CharacterSet
        let filtered : String = self.components(separatedBy: invalidCharSet).joined(separator: "")
        return (self == filtered)
    }
    var isNumber : Bool{
        let invalidCharSet = CharacterSet(charactersIn: "1234567890").inverted as CharacterSet
        let filtered : String = self.components(separatedBy: invalidCharSet).joined(separator: "")
        return (self == filtered)
    }
    func widhtOfString (_ font : UIFont,height : CGFloat) -> CGFloat {
        let attributes = [NSAttributedString.Key.font:font]
        let rect = NSString(string: self).boundingRect(
            with: CGSize(width: CGFloat.greatestFiniteMagnitude,height: height),
            options: NSStringDrawingOptions.usesLineFragmentOrigin,
            attributes: attributes, context: nil)
        return  rect.size.width
    }
    func millisecondToDateString(_ formate : String) -> String {
        return millisecondToDate.toString(formate)!
    }
    var millisecondToDate : Date {
        return Date(timeIntervalSince1970: Double(self) != nil ? Double(self)!  / 1000: 0)
    }
    func intervalToDateString(_ formate : String) -> String {
        return intervalToDate.toString(formate)!
    }
    var intervalToDate : Date {
        return Date(timeIntervalSince1970: Double(self) != nil ? Double(self)! : 0)
    }
    func toDate( _ format:String) -> Date? {
        let formatter:DateFormatter = DateFormatter()
        formatter.locale = Locale(identifier: "en_US_POSIX")
        formatter.timeZone =  TimeZone.ReferenceType.local
        formatter.dateFormat = format
        return formatter.date(from: self)
    }
    var trim : String {
        return self.trimmingCharacters(in: CharacterSet.whitespaces)
    }
    var length : Int {
        return self.count
    }
    var ns: NSString {
        return self as NSString
    }
    var pathExtension: String? {
        return ns.pathExtension
    }
    var lastPathComponent: String? {
        return ns.lastPathComponent
    }
    
    func contains(_ s: String) -> Bool
    {
        return self.range(of: s) != nil ? true : false
    }
    
    func isMatch(_ regex: String, options: NSRegularExpression.Options) -> Bool
    {
        do {
            let exp = try NSRegularExpression(pattern: regex, options: options)
            let matchCount = exp.numberOfMatches(in: self, options: [], range: NSMakeRange(0, self.length))
            return matchCount > 0
        }
        catch {
            return false
        }
        
    }
    func getMatches(_ regex: String, options: NSRegularExpression.Options) -> [NSTextCheckingResult]
    {
        do {
            let exp = try NSRegularExpression(pattern: regex, options: options)
            let matches = exp.matches(in: self, options: [], range: NSMakeRange(0, self.length))
            return matches as [NSTextCheckingResult]
        }
        catch {
            return [NSTextCheckingResult]()
        }
        
    }
}
extension String.Index{
    func successor(in string:String)->String.Index{
        return string.index(after: self)
    }
    
    func predecessor(in string:String)->String.Index{
        return string.index(before: self)
    }
    
    func advance(_ offset:Int,for string:String)->String.Index{
        return string.index(self, offsetBy: offset)
    }
}
