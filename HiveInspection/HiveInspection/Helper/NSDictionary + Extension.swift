//
//  NSDictionary + Extension.swift
//  PogChamp
//
//  Created by Trupen Chauhan on 23/06/20.
//  Copyright © 2020 letsnurture. All rights reserved.
//

import Foundation

extension NSDictionary {
    
    func getStringValue(from key : String) -> String {
        if let getString = self.value(forKey: key) as? NSNumber {
            return getString.stringValue
        }else if let getString = self.value(forKey: key) as? String {
            return getString
        }
        return ""
    }
    
    func getStringValueWithKeypath(from keyPath : String) -> String {
        if let getString = self.value(forKeyPath: keyPath) as? NSNumber {
            return getString.stringValue
        }else if let getString = self.value(forKeyPath: keyPath) as? String {
            return getString
        }
        return ""
    }
    
    func getIntValue(from key : String) -> Int {
        if let getString = self.value(forKey: key) as? NSNumber {
            return getString.intValue
        }else if let getString = self.value(forKey: key) as? NSString {
            return getString.integerValue
        }
        return 0
    }
    
    func getIntValueWithKeyPath(from keyPath : String) -> Int {
        if let getString = self.value(forKeyPath: keyPath) as? NSNumber {
            return getString.intValue
        }else if let getString = self.value(forKeyPath: keyPath) as? NSString {
            return getString.integerValue
        }
        return 0
    }
    
    func getDoubleValue(from key : String) -> Double {
        if let getString = self.value(forKey: key) as? NSNumber {
            return getString.doubleValue
        }else if let getString = self.value(forKey: key) as? NSString {
            return getString.doubleValue
        }
        return 0.0
    }
    
    func getFloatValue(from key : String) -> Float {
        if let getString = self.value(forKey: key) as? NSNumber {
            return getString.floatValue
        }else if let getString = self.value(forKey: key) as? NSString {
            return getString.floatValue
        }
        return 0.0
    }
}
