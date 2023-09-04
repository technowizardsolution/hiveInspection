//
//  SignUpModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 04/09/23.
//

import EVReflection

// MARK: - SignUpWelcome
struct SignUpModel: Codable {
    let status: Int?
    let message: String?

    enum CodingKeys: String, CodingKey {
        case status = "status"
        case message = "message"
    }
}
