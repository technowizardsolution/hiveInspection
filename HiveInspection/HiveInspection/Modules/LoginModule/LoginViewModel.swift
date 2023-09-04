//
//  LoginViewModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 04/09/23.
//

import Foundation

protocol LoginResponse {
    func getLoginResponse(_ model : LoginModel)
    func failureResponse(_ error : String)
}

class LoginViewModel : NSObject {
    var loginModel : LoginModel?
    var delegate : LoginResponse?
    
    override init() {
        super.init()
    }
}

extension LoginViewModel {
    func callLoginAPI(_ param : [String:Any]) {
        APIHandler.shared.networkManager.login(param) { [weak self] _result in
            guard let weakSelf = self else { return }
            switch _result {
            case .success(let loginResponse):
                weakSelf.delegate?.getLoginResponse(loginResponse)
                break
            case .failure(let err):
                weakSelf.delegate?.failureResponse(err.localizedDescription)
                break
            }
        }
    }
}
