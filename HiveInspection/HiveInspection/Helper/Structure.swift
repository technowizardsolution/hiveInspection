//
//  Structure.swift
//  HiveInspection
//
//  Created by LN-iMAC-004 on 25/08/23.
//

import Foundation

struct LoginValidation {
    var email : String = ""
    var password : String = ""
}

struct HiveSetup {
    var name : String = ""
    var isSelected = false
}

struct SettingsData {
    var title : String = ""
    var type : SettingsType = .detail
}

struct HiveInspectData {
    var title : String = ""
    var type : HiveInspectionType = .text
}
