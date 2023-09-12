//
//  HiveSetupModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 05/09/23.
//

import Foundation

// MARK: - HiveSetupModelWelcome
struct HiveSetupModel: Codable {
    let status: Int?
    let message: String?
    let data: HiveSetupModelData?

    enum CodingKeys: String, CodingKey {
        case status = "status"
        case message = "message"
        case data = "data"
    }
}

// MARK: - HiveSetupModelData
struct HiveSetupModelData: Codable {
    let hiveid: Int?
    let userid: Int?
    let hiveName: String?
    let location: String?
    let buildDate: String?
    let origin: String?
    let deeps: String?
    let mediums: String?
    let queenIntroduced: String?
    let createdAt: String?
    let updatedAt: String?
    let deletedAt: String?

    enum CodingKeys: String, CodingKey {
        case hiveid = "hive_id"
        case userid = "user_id"
        case hiveName = "hive_name"
        case location = "location"
        case buildDate = "build_date"
        case origin = "origin"
        case deeps = "deeps"
        case mediums = "mediums"
        case queenIntroduced = "queen_introduced"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case deletedAt = "deleted_at"
    }
}
