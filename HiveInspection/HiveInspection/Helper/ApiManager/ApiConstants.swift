//
//  ApiConstants.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 04/09/23.
//

import UIKit

enum Constants {
    enum baseURL {
        static let baseUrl = "http://13.41.120.190/hiveInspection/api"
    }
    
    enum API {
        static let login = "login"
        static let signup = "register"
        static let addUpdateHive = "addUpdateHive"
        static let hiveList = "getHiveList"
        static let changePassword = "changePassword"
        static let cms = "getCMSpages"
        static let deleteHive = "deleteHive"
        static let addInspection = "addInspection"
        static let forgotPassword = "forgotPassword"
        static let exportReport = "inspectionExport"
    }
    
    static func FCMToken() -> String {
        guard let fcm = UserDefaults.standard.object(forKey: "fcmToken") as? String else { return "" }
        return fcm
    }
    
    static func getToken() -> String {
        guard let fcm = UserDefaults.standard.object(forKey: "token") as? String else { return "" }
        return fcm
    }
    
    static func getUserId() -> String {
        guard let userId = UserDefaults.standard.object(forKey: "UserId") as? String else { return "" }
        return userId
    }
    
    static func clearDefaults() {
        UserDefaults.standard.removeObject(forKey: "token")
        UserDefaults.standard.removeObject(forKey: "UserId")
        UserDefaults.standard.removeObject(forKey: "fcmToken")
    }
}