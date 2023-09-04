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
    }
    
    static func FCMToken() -> String {
        guard let fcm = UserDefaults.standard.object(forKey: "fcmToken") as? String else { return "" }
        return fcm
    }
    
    static func getToken() -> String {
        guard let fcm = UserDefaults.standard.object(forKey: "token") as? String else { return "" }
        return fcm
    }
}
