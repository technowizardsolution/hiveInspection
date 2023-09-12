//
//  ValidateData.swift
//  HiveInspection
//
//  Created by LN-iMAC-004 on 25/08/23.
//

import Foundation

func checkLoginValidation(validationModel : LoginValidation) -> (Bool,String) {
//    return (true,"")
    if validationModel.email == "" {
        return (false,popupMessages.noEmail.rawValue)
    }else if validateEmailWithString(validationModel.email) {
        return (false,popupMessages.correctEmail.rawValue)
    }else if validationModel.password == "" {
        return (false,popupMessages.noPassword.rawValue)
    }else if validePassword((validationModel.password) as NSString) {
        return (false,popupMessages.incorrectPassword.rawValue)
    }
    return (true,"")
}

func checkAddAHiveValidation(validationModel : AddAHiveValidation) -> (Bool,String) {
    if validationModel.hiveName == "" {
        return (false,popupMessages.noHiveName.rawValue)
    }else if validationModel.hiveLocation == "" {
        return (false,popupMessages.noHiveLocation.rawValue)
    }
    return (true,"")
}

func checkChangePasswordValidation(validationModel : ChangePasswordValidation) -> (Bool,String) {
    if validationModel.oldPassword == "" {
        return (false,popupMessages.noOldPassword.rawValue)
    }else if validationModel.newPassword == "" {
        return (false,popupMessages.noNewPassword.rawValue)
    }else if validationModel.newPassword != validationModel.newConfirmPassword {
        return (false,popupMessages.confirmNotMatch.rawValue)
    }
    return (true,"")
}
