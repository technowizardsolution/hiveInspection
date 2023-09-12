//
//  HiveListViewModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 09/09/23.
//

import Foundation
import SVProgressHUD
protocol HiveListResponse {
    func getHiveListResponse(_ model : HiveListModel)
    func deleteHiveResponse(_ model : HiveListDeleteModel)
    func failureResponse(_ error : String)
}

class HiveListViewModel : NSObject {
    var hiveListModel : HiveListModel?
    var delegate : HiveListResponse?
    
    override init() {
        super.init()
    }
}

extension HiveListViewModel {
    func callAPI() {
        SVProgressHUD.show(withStatus: "Please wait")
        APIHandler.shared.networkManager.hiveList { [weak self] _result in
            SVProgressHUD.dismiss()
            guard let weakSelf = self else { return }
            switch _result {
            case .success(let response):
                weakSelf.hiveListModel = response
                weakSelf.delegate?.getHiveListResponse(response)
                break
            case .failure(let err):
                weakSelf.delegate?.failureResponse(err.localizedDescription)
                break
            }
        }
    }
    
    func callDeleteHiveAPI(param : [String:Any]) {
        SVProgressHUD.show()
        APIHandler.shared.networkManager.deleteHive(param) { [weak self] _result in
            SVProgressHUD.dismiss()
            guard let weakSelf = self else { return }
            switch _result {
            case .success(let loginResponse):
                weakSelf.delegate?.deleteHiveResponse(loginResponse)
                break
            case .failure(let err):
                weakSelf.delegate?.failureResponse(err.localizedDescription)
                break
            }
        }
    }
}
