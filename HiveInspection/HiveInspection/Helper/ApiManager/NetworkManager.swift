//
//  NetworkManager.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 04/09/23.
//

import Moya

protocol Networkable {
    var provider: MoyaProvider<API> { get }
    
    func login(_ param : [String:Any], completion: @escaping (Result<LoginModel, Error>) -> ())
    
    func signup(_ param : [String:Any], completion: @escaping (Result<SignUpModel, Error>) -> ())
    
    func addUpdateHive(_ param : [String:Any], completion: @escaping (Result<HiveSetupModel, Error>) -> ())
    
    func hiveList(completion: @escaping (Result<HiveListModel, Error>) -> ())
    
    func changepassword(_ param : [String:Any], completion: @escaping (Result<LoginModel, Error>) -> ())
    
    func cms(_ param : [String:Any], completion: @escaping (Result<CMSModel, Error>) -> ())
    
    func deleteHive(_ param : [String:Any], completion: @escaping (Result<HiveListDeleteModel, Error>) -> ())
    
    func addInspection(_ param : [String:Any], completion: @escaping (Result<HiveInspectModel, Error>) -> ())
    
    func forgotPassword(_ param : [String:Any], completion: @escaping (Result<ForgotPasswordModel, Error>) -> ())
    
    func hiveInspectionReportExport(_ param : [String:Any], completion: @escaping (Result<ExportInspectionModel, Error>) -> ())
    
    func getProfile(_ param: [String : Any],completion: @escaping (Result<ProfileModel, Error>) -> ())
    
    func updateNotification(_ param: [String : Any],completion: @escaping (Result<SignUpModel, Error>) -> ())
}

class NetworkManager: Networkable {
    var provider = MoyaProvider<API>(plugins: [NetworkLoggerPlugin()])
    
    func login(_ param: [String : Any], completion: @escaping (Result<LoginModel, Error>) -> ()) {
        request(target: API.login(param: param), completion: completion)
    }
    
    func socialLogin(_ param: [String : Any], completion: @escaping (Result<LoginModel, Error>) -> ()) {
        request(target: API.socialLogin(param: param), completion: completion)
    }
    
    func signup(_ param: [String : Any], completion: @escaping (Result<SignUpModel, Error>) -> ()) {
        request(target: API.signUp(param: param), completion: completion)
    }
    
    func addUpdateHive(_ param: [String : Any], completion: @escaping (Result<HiveSetupModel, Error>) -> ()) {
        request(target: API.addUpdateHive(param: param), completion: completion)
    }
    
    func hiveList(completion: @escaping (Result<HiveListModel, Error>) -> ()) {
        request(target: API.hiveList, completion: completion)
    }
    
    func changepassword(_ param: [String : Any], completion: @escaping (Result<LoginModel, Error>) -> ()) {
        request(target: API.changePassword(param: param), completion: completion)
    }
    
    func cms(_ param: [String : Any], completion: @escaping (Result<CMSModel, Error>) -> ()) {
        request(target: API.CMS(param: param), completion: completion)
    }
    
    func deleteHive(_ param: [String : Any], completion: @escaping (Result<HiveListDeleteModel, Error>) -> ()) {
        request(target: API.deleteHive(param: param), completion: completion)
    }
    
    func addInspection(_ param: [String : Any], completion: @escaping (Result<HiveInspectModel, Error>) -> ()) {
        request(target: API.addInspect(param: param), completion: completion)
    }
    
    func forgotPassword(_ param: [String : Any], completion: @escaping (Result<ForgotPasswordModel, Error>) -> ()) {
        request(target: API.forgotPassword(param: param), completion: completion)
    }
    
    func hiveInspectionReportExport(_ param: [String : Any], completion: @escaping (Result<ExportInspectionModel, Error>) -> ()) {
        request(target: API.inspectionExport(param: param), completion: completion)
    }
    
    func getProfile(_ param: [String : Any], completion: @escaping (Result<ProfileModel, Error>) -> ()) {
        request(target: API.getProfile(param: param), completion: completion)
    }
    
    func updateNotification(_ param: [String : Any], completion: @escaping (Result<SignUpModel, Error>) -> ()) {
        request(target: API.updateNotification(param: param), completion: completion)
    }
}

private extension NetworkManager {
    private func request<T: Decodable>(target: API, completion: @escaping (Result<T, Error>) -> ()) {
        provider.request(target) { result in
            switch result {
            case let .success(response):
                do {
                    print(dataToJSON(data: response.data))
                    let results = try JSONDecoder().decode(T.self, from: response.data)
                    completion(.success(results))
                } catch let error {
                    completion(.failure(error))
                }
            case let .failure(error):
                completion(.failure(error))
            }
        }
    }
}
// Convert from NSData to json object
func dataToJSON(data: Data) -> AnyObject? {
    do {
        return try JSONSerialization.jsonObject(with: data) as AnyObject
    } catch let myJSONError {
        print(myJSONError)
    }
    return nil
}
