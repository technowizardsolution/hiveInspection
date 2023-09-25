//
//  MoyaHandler.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 04/09/23.
//

import Moya


enum API {
    case login(param : [String:Any])
    case socialLogin(param : [String:Any])
    case signUp(param : [String:Any])
    case addUpdateHive(param : [String:Any])
    case hiveList
    case changePassword(param : [String:Any])
    case CMS(param : [String:Any])
    case deleteHive(param : [String:Any])
    case addInspect(param : [String:Any])
    case forgotPassword(param : [String:Any])
    case inspectionExport(param : [String:Any])
}

extension API : TargetType {
    var path: String {
        switch self {
        case .login:
            return Constants.API.login
        case .socialLogin:
            return Constants.API.socialRegister
        case .signUp:
            return Constants.API.signup
        case .addUpdateHive:
            return Constants.API.addUpdateHive
        case .hiveList:
            return Constants.API.hiveList
        case .changePassword:
            return Constants.API.changePassword
        case .CMS:
            return Constants.API.cms
        case .deleteHive:
            return Constants.API.deleteHive
        case .addInspect:
            return Constants.API.addInspection
        case .forgotPassword:
            return Constants.API.forgotPassword
        case .inspectionExport:
            return Constants.API.exportReport
        }
    }
    
    var method: Moya.Method {
        switch self {
        case .login, .signUp, .addUpdateHive, .changePassword, .CMS, .deleteHive, .addInspect, .forgotPassword, .inspectionExport, .socialLogin:
            return .post
        case .hiveList:
            return .get
        }
    }
    
    var sampleData: Data {
        return Data()
    }
    
    var task: Moya.Task {
        switch self {
        case .login(param: let param), .signUp(param: let param), .addUpdateHive(param: let param), .changePassword(param: let param), .CMS(param: let param), .deleteHive(param: let param), .addInspect(param: let param), .forgotPassword(param: let param), .inspectionExport(param: let param), .socialLogin(param: let param):
            return .requestParameters(parameters: param, encoding: JSONEncoding.default)
        case .hiveList:
            return .requestPlain
        }
    }
    
    var headers: [String : String]? {
        switch self {
        case .login, .signUp, .socialLogin:
            return ["Content-type": "application/json"]
        default:
            return ["Content-type": "application/json","Authorization" : "Bearer \(Constants.getToken())"]
        }
    }
    
    var baseURL: URL {
        guard let url = URL(string: Constants.baseURL.baseUrl) else { fatalError() }
        return url
    }
}
