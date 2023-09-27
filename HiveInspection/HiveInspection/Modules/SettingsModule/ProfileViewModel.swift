//
//  ProfileViewModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 26/09/23.
//

import Foundation
import SVProgressHUD

protocol ProfileResponse {
    func getProfileResponse(_ model : ProfileModel)
    func updateNotificationResponse(_ model : SignUpModel)
    func failureResponse(_ error : String)
}

class ProfileViewModel : NSObject {
    var profileData : ProfileModel?
    var delegate : ProfileResponse?
    
    override init() {
        super.init()
    }
}

extension ProfileViewModel {
    func callAPI() {
        SVProgressHUD.show(withStatus: "Please wait")
        APIHandler.shared.networkManager.getProfile(["":""]) { [weak self] _result in
            SVProgressHUD.dismiss()
            guard let weakSelf = self else { return }
            switch _result {
            case .success(let response):
                weakSelf.profileData = response
                weakSelf.delegate?.getProfileResponse(response)
                break
            case .failure(let err):
                weakSelf.delegate?.failureResponse(err.localizedDescription)
                break
            }
        }
    }
    
    func callNotificationUpdateAPI(param : [String:Any]) {
        SVProgressHUD.show()
        APIHandler.shared.networkManager.updateNotification(param) { [weak self] _result in
            SVProgressHUD.dismiss()
            guard let weakSelf = self else { return }
            switch _result {
            case .success(let loginResponse):
                weakSelf.delegate?.updateNotificationResponse(loginResponse)
                break
            case .failure(let err):
                weakSelf.delegate?.failureResponse(err.localizedDescription)
                break
            }
        }
    }
}
