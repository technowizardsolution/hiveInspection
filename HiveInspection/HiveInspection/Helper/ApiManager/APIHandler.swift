//
//  APIHandler.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 04/09/23.
//

import Moya
import Foundation

class APIHandler : NSObject {
    static let shared : APIHandler = APIHandler()
    let networkManager: NetworkManager = NetworkManager()
}
