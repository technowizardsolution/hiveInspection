//
//  CMSViewModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 11/09/23.
//

import Foundation

protocol CMSResponse {
    func getCMSResponse(_ model : CMSModel)
    func failureResponse(_ error : String)
}

class CMSViewModel : NSObject {
    var CMSModel : CMSModel?
    var delegate : CMSResponse?
    
    override init() {
        super.init()
    }
}

extension CMSViewModel {
    func callAPI(_ param : [String:Any]) {
        APIHandler.shared.networkManager.cms(param) { [weak self] _result in
            guard let weakSelf = self else { return }
            switch _result {
            case .success(let loginResponse):
                weakSelf.delegate?.getCMSResponse(loginResponse)
                break
            case .failure(let err):
                weakSelf.delegate?.failureResponse(err.localizedDescription)
                break
            }
        }
    }
}
