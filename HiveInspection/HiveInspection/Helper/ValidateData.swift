//
//  ValidateData.swift
//  HiveInspection
//
//  Created by LN-iMAC-004 on 25/08/23.
//

import Foundation

func checkLoginValidation(validationModel : LoginValidation) -> (Bool,String) {
    return (true,"")
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
