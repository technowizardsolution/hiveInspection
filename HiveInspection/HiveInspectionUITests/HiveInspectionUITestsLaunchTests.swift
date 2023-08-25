//
//  HiveInspectionUITestsLaunchTests.swift
//  HiveInspectionUITests
//
//  Created by Trupen Chauhan on 24/08/23.
//

import XCTest

final class HiveInspectionUITestsLaunchTests: XCTestCase {
    let app = XCUIApplication()

    override func setUpWithError() throws {
        continueAfterFailure = false
    }

    func testSignUp() {
        app.launch()
        app.buttons["Create Account"].tap()
    }

    func testSignIn() {
        app.launch()
        app.buttons["Login"].tap()
    }
}
