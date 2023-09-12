//
//  HiveSetupViewModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 05/09/23.
//

import Foundation
protocol HiveSetupResponse {
    func getHiveSetupResponse(_ model : HiveSetupModel)
    func failureResponse(_ error : String)
}

class HiveSetupViewModel : NSObject {
    var hiveSetupModel : HiveSetupModel?
    var delegate : HiveSetupResponse?
    
    override init() {
        super.init()
    }
}

extension HiveSetupViewModel {
    func callAPI(_ param : [String:Any]) {
        APIHandler.shared.networkManager.addUpdateHive(param) { [weak self] _result in
            guard let weakSelf = self else { return }
            switch _result {
            case .success(let loginResponse):
                weakSelf.delegate?.getHiveSetupResponse(loginResponse)
                break
            case .failure(let err):
                weakSelf.delegate?.failureResponse(err.localizedDescription)
                break
            }
        }
    }
}
