//
//  LoginWithGoogle.swift
//  PogChamp
//
//  Created by Trupen Chauhan on 23/06/20.
//  Copyright © 2020 letsnurture. All rights reserved.
//

import Foundation
import GoogleSignIn
import Firebase
//MARK: - Add GIDClientID Key in info.plist file
class LoginWithGoogle : NSObject {

    private var googleSignIn: GIDSignIn? = nil
    var completionHandlerGoogleSigninData : ((GIDGoogleUser?) -> ())? = nil
    class var shared : LoginWithGoogle {
        struct Static {
            static let instance : LoginWithGoogle = LoginWithGoogle()
        }
        return Static.instance
    }

    override init() {
        super.init()
    }

    func loginWithGoogle(completionHandler : @escaping (GIDGoogleUser?) -> ()) {
        completionHandlerGoogleSigninData = completionHandler
        appDelegate.window?.rootViewController?.view.endEditing(true)
        GIDSignIn.sharedInstance.signIn(withPresenting: appDelegate.window?.rootViewController ?? UIViewController(), completion: { user, err in
            guard err == nil else { return }
            guard let user = user else { return }
            if self.completionHandlerGoogleSigninData != nil {
                self.completionHandlerGoogleSigninData!(user.user)
            }
        })
    }
}
