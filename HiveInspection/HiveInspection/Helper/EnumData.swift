//
//  EnumData.swift
//  HiveInspection
//
//  Created by LN-iMAC-004 on 25/08/23.
//

import Foundation

enum popupMessages : String {
    case noEmail = "Please enter your email id"
    case correctEmail = "Please check your email id"
    case noPassword = "Please enter your password"
    case incorrectPassword = "Your password should be 6 or more characters long"
}

enum SettingsType {
    case detail
    case _switch
    case version
    case none
}

enum HiveInspectionType {
    case date
    case _switch
    case _switchWithText
    case text
    case dropdown
    case none
    case frontSwitch
}
