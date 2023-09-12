//
//  CMSModel.swift
//  HiveInspection
//
//  Created by Trupen Chauhan on 11/09/23.
//

import Foundation

// MARK: - CMSModel
struct CMSModel: Codable {
    let status: Int?
    let message: String?
    let data: CMSModelData?

    enum CodingKeys: String, CodingKey {
        case status = "status"
        case message = "message"
        case data = "data"
    }
}

// MARK: - CMSModelData
struct CMSModelData: Codable {
    let cmsPageid: Int?
    let pageTitle: String?
    let slug: String?
    let content: String?
    let metaDescription: String?
    let metaKeyword: String?
    let status: String?
    let createdAt: String?
    let updatedAt: String?
    let deletedAt: String?

    enum CodingKeys: String, CodingKey {
        case cmsPageid = "cms_page_id"
        case pageTitle = "page_title"
        case slug = "slug"
        case content = "content"
        case metaDescription = "metaDescription"
        case metaKeyword = "metaKeyword"
        case status = "status"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case deletedAt = "deleted_at"
    }
}
