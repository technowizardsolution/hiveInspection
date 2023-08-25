//
//  WelcomeUITests.swift
//  HiveInspectionUITests
//
//  Created by LN-iMAC-004 on 25/08/23.
//

import XCTest

final class WelcomeUITests: XCTestCase {

    var app = XCUIApplication()

    func testLogin() {
        app.launch()

        app.buttons["Login"].tap()
        app.buttons["Login"].tap()
        app.buttons["OK"].tap()

        let textField = app.textFields["Email"]
        textField.tap()
        textField.typeText("chauhantrupen@")
        app.buttons["Login"].tap()
        app.buttons["OK"].tap()
        textField.clearAndEnterText(text: "chauhantrupen@gmail.com")
        app.buttons["Login"].tap()

        let textFieldPassword = app.textFields["Password"]
        textFieldPassword.tap()
        textFieldPassword.typeText("123")
        app.buttons["Login"].tap()
        app.buttons["OK"].tap()
        textFieldPassword.clearAndEnterText(text: "123332")
        app.buttons["Login"].tap()
    }

    func testCreateAccount() {
        app.launch()
        app.buttons["Create Account"].tap()
    }
}

