//
//  LoginWithApple.swift
//  PogChamp
//
//  Created by Trupen Chauhan on 23/06/20.
//  Copyright © 2020 letsnurture. All rights reserved.
//

import Foundation
import AuthenticationServices

@available(iOS 13.0, *)
class LoginWithApple : NSObject, ASAuthorizationControllerDelegate, ASAuthorizationControllerPresentationContextProviding {

    private let authorizationController:ASAuthorizationController? = nil

    var completionHandlerAppleSigninData : ((ASAuthorizationAppleIDCredential?) -> ())? = nil

    class var shared : LoginWithApple {
        struct Static {
            static let instance : LoginWithApple = LoginWithApple()
        }
        return Static.instance
    }

    override init() {
        super.init()
    }

    func loginWithApple(completionHandler : @escaping (ASAuthorizationAppleIDCredential?) -> ()) {
        completionHandlerAppleSigninData = completionHandler
        let appleIDProvider = ASAuthorizationAppleIDProvider()
        let request = appleIDProvider.createRequest()
        request.requestedScopes = [.fullName, .email];
        let authorizationController = ASAuthorizationController(authorizationRequests: [request])
        authorizationController.delegate = self
        authorizationController.presentationContextProvider = self
        authorizationController.performRequests()
    }

    func presentationAnchor(for controller: ASAuthorizationController) -> ASPresentationAnchor {
        return (appDelegate.window?.rootViewController?.view.window)!
    }

    func authorizationController(controller: ASAuthorizationController, didCompleteWithAuthorization authorization: ASAuthorization) {
        if let appleIDCredential = authorization.credential as?  ASAuthorizationAppleIDCredential {
            KeychainItem.currentUserIdentifier = appleIDCredential.user
            KeychainItem.currentUserName = (appleIDCredential.fullName?.givenName ?? "") + " " + (appleIDCredential.fullName?.familyName ?? "")
            KeychainItem.currentUserEmail = appleIDCredential.email
            guard let idTokenString = String(data: appleIDCredential.identityToken ?? Data(), encoding: .utf8) else { return }
            KeychainItem.identityToken = idTokenString
            guard let codeString = String(data: appleIDCredential.authorizationCode ?? Data(), encoding: .utf8) else { return }
            KeychainItem.authCode = codeString
            completionHandlerAppleSigninData!(appleIDCredential)
        }
    }

    func authorizationController(controller: ASAuthorizationController, didCompleteWithError error: Error) {
//        dPrint(error.localizedDescription)
    }
}
