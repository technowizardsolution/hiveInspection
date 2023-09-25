//
//  LoginWithFacebook.swift
//  PogChamp
//
//  Created by Trupen Chauhan on 23/06/20.
//  Copyright © 2020 letsnurture. All rights reserved.
//

/**
 Response from Facebook Profile
 {
     "first_name" = "";
     id = "" ;
     "last_name" = "" ;
     name = "";
     picture =     {
         data =         {
             height = 200;
             "is_silhouette" = 0;
             url = "";
             width = 200;
         };
     };
}
 */

/**
 Note : -  Here Project needs to add URL Type for facebook which can be found under Project Target > Info > URL Types.
 */

import UIKit
import FBSDKLoginKit

struct FBStaticKeywords {
    static let publicProfile = "public_profile"
    static let email = "email"
    static let graphPath = "me"
    static let parameters : [String : String] = ["fields": "id, name, first_name, last_name, picture.type(large), email"]
}

class FacebookProfileModel : NSObject {
    var FBId = String()
    var firstName = String()
    var lastName = String()
    var name = String()
    var email = String()
    var pictureUrl = String()
    var pictureHeight = Int()
    var pictureWidth = Int()

    init(fromDictionary Dict : NSDictionary) {
        FBId = Dict.getStringValue(from: "id")
        firstName = Dict.getStringValue(from: "first_name")
        lastName = Dict.getStringValue(from: "last_name")
        name = Dict.getStringValue(from: "name")
        email = Dict.getStringValue(from: "email")
        pictureUrl = Dict.getStringValueWithKeypath(from: "picture.data.url")
        pictureHeight = Dict.getIntValueWithKeyPath(from: "picture.data.height")
        pictureWidth = Dict.getIntValueWithKeyPath(from: "picture.data.width")
    }
}

class LoginWithFacebook : NSObject {

    private var fbLoginManager : LoginManager = LoginManager()

    let post = String(format: "fb://")
    var getFacebookProfile : FacebookProfileModel? = nil
    class var shared : LoginWithFacebook {
        struct Static {
            static let instance : LoginWithFacebook = LoginWithFacebook()
        }
        return Static.instance
    }

    func loginWithFacebook(completionHandler : @escaping (FacebookProfileModel?) -> ()) {
        fbLoginManager.logIn(permissions: [FBStaticKeywords.publicProfile, FBStaticKeywords.email], from: appDelegate.window?.rootViewController) { (loginResults, error) in
            if error == nil, AccessToken.current != nil {
                print("Facebook Token : \(AccessToken.current?.tokenString ?? "")")
            }
            GraphRequest(graphPath: FBStaticKeywords.graphPath,parameters: FBStaticKeywords.parameters).start { (graphReqConnections,graphResult, graphError) in
                if graphError == nil {
                    guard let fbDictionary = graphResult as? NSDictionary else { return }
                    print("Facebook Returned Data : \(fbDictionary)")
                    self.getFacebookProfile = FacebookProfileModel(fromDictionary: fbDictionary)
                    if self.getFacebookProfile != nil {
                        completionHandler(self.getFacebookProfile!)
                    }
                }
            }
        }
    }
}
