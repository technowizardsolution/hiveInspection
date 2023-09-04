//
//  SignUpViewModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 04/09/23.
//

import Foundation

protocol SignUpResponse {
    func getSignUpResponse(_ model : SignUpModel)
    func failureResponse(_ error : String)
}

class SignUpViewModel : NSObject {
    var signUpModel : SignUpModel?
    var delegate : SignUpResponse?
    
    override init() {
        super.init()
    }
}

extension SignUpViewModel {
    func callSignUpAPI(_ param : [String:Any]) {
        APIHandler.shared.networkManager.signup(param) { [weak self] _result in
            guard let weakSelf = self else { return }
            switch _result {
            case .success(let loginResponse):
                weakSelf.delegate?.getSignUpResponse(loginResponse)
                break
            case .failure(let err):
                weakSelf.delegate?.failureResponse(err.localizedDescription)
                break
            }
        }
    }
}
