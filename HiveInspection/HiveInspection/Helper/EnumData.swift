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
    case noHiveName = "Please enter a hive name"
    case noHiveLocation = "Please enter a hive location"
    case noOldPassword = "Please enter old password"
    case noNewPassword = "Please enter new password"
    case confirmNotMatch = "Password and confirm password do not match"
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
    case _switchWithDropDown
    case _frontSwitchWithDate
    case text
    case dropdown
    case none
    case frontSwitch
}

enum CMSPages : String {
    case aboutus = "about"
    case termsandcondition = "terms-and-conditions"
    case privacypolicy = "privacy-policy"
}

enum settingTitle : String {
    case AddaHive = "Add a Hive"
    case Notifications = "Notifications"
    case AboutUs = "About Us"
    case ChangePassword = "Change Password"
    case TermsConditions = "Terms & Conditions"
    case PrivacyPolicy = "Privacy Policy"
    case AppVersion = "App Version"
    case Logout = "Logout"
    case DeleteAccount = "Delete Account"
}
