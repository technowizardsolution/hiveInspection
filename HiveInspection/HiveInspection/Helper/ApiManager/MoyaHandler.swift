//
//  MoyaHandler.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 04/09/23.
//

import Moya


enum API {
    case Login(param : [String:Any])
    case SignUp(param : [String:Any])
}

extension API : TargetType {
    var path: String {
        switch self {
        case .Login:
            return Constants.API.login
        case .SignUp:
            return Constants.API.signup
        }
    }
    
    var method: Moya.Method {
        switch self {
        case .Login, .SignUp:
            return .post
        }
    }
    
    var sampleData: Data {
        return Data()
    }
    
    var task: Moya.Task {
        switch self {
        case .Login(param: let param), .SignUp(param: let param):
            return .requestParameters(parameters: param, encoding: URLEncoding.default)
        }
    }
    
    var headers: [String : String]? {
        return ["Content-type": "application/json"]
    }
    
    var baseURL: URL {
        guard let url = URL(string: Constants.baseURL.baseUrl) else { fatalError() }
        return url
    }
}
