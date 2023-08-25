import Foundation
import UIKit
import CoreGraphics
import CoreData
import SystemConfiguration

let IS_IPAD = UIDevice.current.userInterfaceIdiom == .pad
let IS_IPHONE = UIDevice.current.userInterfaceIdiom == UIUserInterfaceIdiom.phone
let SCREEN_WIDTH = UIScreen.main.bounds.size.width
let SCREEN_HEIGHT = UIScreen.main.bounds.size.height
let SCREEN_MAX_LENGTH = max(SCREEN_WIDTH, SCREEN_HEIGHT)
let SCREEN_MIN_LENGTH = min(SCREEN_WIDTH, SCREEN_HEIGHT)

let IS_IPHONE_4_OR_LESS = IS_IPHONE && SCREEN_MAX_LENGTH < 568.0
let IS_IPHONE_5 = IS_IPHONE && SCREEN_MAX_LENGTH == 568.0
let IS_IPHONE_6 = IS_IPHONE && SCREEN_MAX_LENGTH == 667.0
let IS_IPHONE_6P = IS_IPHONE && SCREEN_MAX_LENGTH == 736.0


public typealias TimerTickClosure = (Timer)->Void
public typealias TimerTickBlock = @convention(block) (Timer)->Void
public typealias stringBlock = (String)->()
public typealias voidBlock = ()->()
public typealias objectBlock = (AnyObject?)->()

let appDelegate = UIApplication.shared.delegate as! AppDelegate
let mainStoryBoard = UIStoryboard(name: "Main", bundle: nil)

public var SCALE_IPHONE : CGFloat {
    if IS_IPHONE_6P {
        return 1.05
    }
    else if IS_IPHONE_5 || IS_IPHONE_4_OR_LESS {
        return 0.91
    }
    return 1.0
}


// MARK: - getImageWithColor Function -
public func getImageWithColor(_ color: UIColor, size: CGSize) -> UIImage {
    let rect  =  CGRect(x: 0, y: 0, width: size.width, height: size.height)
    UIGraphicsBeginImageContextWithOptions(size, false, 0)
    color.setFill()
    UIRectFill(rect)
    let image: UIImage = UIGraphicsGetImageFromCurrentImageContext()!
    UIGraphicsEndImageContext()
    return image
}

open  class Lifted<T> {
    public let value: T
    public init(_ x: T) {
        value = x
    }
}


public func setAssociatedObject<T : UIView>(_ object: AnyObject, value: T, associativeKey: UnsafeRawPointer, policy: objc_AssociationPolicy) {
    if let v: AnyObject = value as? AnyObject {
        objc_setAssociatedObject(object, associativeKey, v,  policy)
    }
    else {
        objc_setAssociatedObject(object, associativeKey, Lifted(value),  policy)
    }
}
public func RADIANS(_ degree :Double) -> Double
{
    return ((degree)*Double.pi/180)
}
public func getAssociatedObject<T : UIView>(_ object: AnyObject, associativeKey: UnsafeRawPointer) -> T? {
    if let v = objc_getAssociatedObject(object, associativeKey) as? T {
        return v
    }
    else if let v = objc_getAssociatedObject(object, associativeKey) as? Lifted<T> {
        return v.value
    }
    else {
        return nil
    }
}
public var sharedCache : NSCache<AnyObject, AnyObject> = NSCache()
func degreesToRadians(_ x : Double) -> Float{
    return Float(Double.pi * x / 180.0)
}
func radiandsToDegrees(_ x : Double) -> Float{
    return Float(x * 180.0 / Double.pi)
}

public func delay(_ delay:Double, closure:@escaping ()->()) {
    DispatchQueue.main.asyncAfter(deadline: .now() + delay) {
        closure()
    }
}



