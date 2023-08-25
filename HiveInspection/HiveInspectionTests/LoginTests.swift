//
//  LoginTests.swift
//  HiveInspectionTests
//
//  Created by LN-iMAC-004 on 25/08/23.
//

import XCTest
@testable import HiveInspection

final class LoginTests: XCTestCase {
    func testLoginValidation() {
        var loginValidation = HiveInspection.LoginValidation()
        loginValidation.email = "chauhantrupen@gmail.com"
        loginValidation.password = "123221"
        let validated = checkLoginValidation(validationModel: loginValidation)
        XCTAssertTrue(validated.0)
    }
}
