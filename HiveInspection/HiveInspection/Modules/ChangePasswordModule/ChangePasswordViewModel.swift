//
//  ChangePasswordViewModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 11/09/23.
//

import Foundation

protocol ChangePasswordResponse {
    func getChangePasswordResponse(_ model : LoginModel)
    func failureResponse(_ error : String)
}

class ChangePasswordViewModel : NSObject {
    var changePasswordModel : LoginModel?
    var delegate : ChangePasswordResponse?
    
    override init() {
        super.init()
    }
}

extension ChangePasswordViewModel {
    func callAPI(_ param : [String:Any]) {
        APIHandler.shared.networkManager.changepassword(param) { [weak self] _result in
            guard let weakSelf = self else { return }
            switch _result {
            case .success(let loginResponse):
                weakSelf.delegate?.getChangePasswordResponse(loginResponse)
                break
            case .failure(let err):
                weakSelf.delegate?.failureResponse(err.localizedDescription)
                break
            }
        }
    }
}
