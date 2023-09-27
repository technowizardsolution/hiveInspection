//
//  ProfileModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 26/09/23.
//

import Foundation

// MARK: - ProfileModel
struct ProfileModel: Codable {
    let status: Int?
    let message: String?
    let data: ProfileData?

    enum CodingKeys: String, CodingKey {
        case status = "status"
        case message = "message"
        case data = "data"
    }
}

// MARK: - ProfileData
struct ProfileData: Codable {
    let id: Int?
    let firstName: String??
    let lastName: String??
    let email: String?
    let emailVerified: String?
    let emailVerifiedAt: String?
    let otp: String?
    let lastLoginAt: String?
    let sessionid: String?
    let passwordResetFrequency: Int?
    let confirmationCode: String?
    let deviceType: String?
    let deviceToken: String?
    let passwordResetToken: String?
    let emailToken: String?
    let isEmailVerify: String?
    let isMobileNumberVerifyed: String?
    let profilePicture: String?
    let adminStatus: String?
    let isDelete: String?
    let socialProviderid: String?
    let socialProvider: String?
    let userStatus: String?
    let notificationStatus: String?
    let createdBy: String?
    let createdAt: String?
    let updatedAt: String?
    let deletedAt: String?
    let roleid: Int?
    let roles: [ProfileRole]?

    enum CodingKeys: String, CodingKey {
        case id = "id"
        case firstName = "first_name"
        case lastName = "last_name"
        case email = "email"
        case emailVerified = "email_verified"
        case emailVerifiedAt = "email_verified_at"
        case otp = "otp"
        case lastLoginAt = "last_login_at"
        case sessionid = "session_id"
        case passwordResetFrequency = "password_reset_frequency"
        case confirmationCode = "confirmation_code"
        case deviceType = "device_type"
        case deviceToken = "device_token"
        case passwordResetToken = "password_reset_token"
        case emailToken = "email_token"
        case isEmailVerify = "is_email_verify"
        case isMobileNumberVerifyed = "is_mobile_number_verifyed"
        case profilePicture = "profile_picture"
        case adminStatus = "admin_status"
        case isDelete = "is_delete"
        case socialProviderid = "social_provider_id"
        case socialProvider = "social_provider"
        case userStatus = "user_status"
        case notificationStatus = "notification_status"
        case createdBy = "created_by"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case deletedAt = "deleted_at"
        case roleid = "role_id"
        case roles = "roles"
    }
}

// MARK: - ProfileRole
struct ProfileRole: Codable {
    let id: Int?
    let name: String?
    let displayName: String?
    let guardName: String?
    let authid: String?
    let createdAt: String?
    let updatedAt: String?
    let deletedAt: String?
    let pivot: ProfilePivot?

    enum CodingKeys: String, CodingKey {
        case id = "id"
        case name = "name"
        case displayName = "display_name"
        case guardName = "guard_name"
        case authid = "auth_id"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case deletedAt = "deleted_at"
        case pivot = "pivot"
    }
}

// MARK: - ProfilePivot
struct ProfilePivot: Codable {
    let modelid: Int?
    let roleid: Int?
    let modelType: String?

    enum CodingKeys: String, CodingKey {
        case modelid = "model_id"
        case roleid = "role_id"
        case modelType = "model_type"
    }
}
