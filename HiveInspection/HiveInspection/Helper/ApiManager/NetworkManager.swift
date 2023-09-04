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
}

class NetworkManager: Networkable {
    var provider = MoyaProvider<API>(plugins: [NetworkLoggerPlugin()])
    
    func login(_ param: [String : Any], completion: @escaping (Result<LoginModel, Error>) -> ()) {
        request(target: API.Login(param: param), completion: completion)
    }
    
    func signup(_ param: [String : Any], completion: @escaping (Result<SignUpModel, Error>) -> ()) {
        request(target: API.SignUp(param: param), completion: completion)
    }
}

private extension NetworkManager {
    private func request<T: Decodable>(target: API, completion: @escaping (Result<T, Error>) -> ()) {
        provider.request(target) { result in
            switch result {
            case let .success(response):
                do {
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
