//
//  ThemeColor.swift
//  Via
//
//  Created by Lokesh Dudhat on 23/11/15.
//  Copyright © 2015 com.letsnurture. All rights reserved.
//
import Foundation
import UIKit
import AVFoundation


extension Data {
    public var hexString: String {
        return map { String(format: "%02.2hhx", arguments: [$0]) }.joined()
    }
}

extension UIView {
    
    func rotate(_ toValue: CGFloat, duration: CFTimeInterval = 0.2) {
        let animation = CABasicAnimation(keyPath: "transform.rotation")
        
        animation.toValue = toValue
        animation.duration = duration
        animation.isRemovedOnCompletion = false
        animation.fillMode = .forwards
        
        self.layer.add(animation, forKey: nil)
    }
    
}


extension UIViewController {
    func changeStatusBarColor(_ color: UIColor){
        if #available(iOS 13.0, *) {
            let app = UIApplication.shared
            let statusBarHeight: CGFloat = app.statusBarFrame.size.height
            let statusbarView = UIView()
            statusbarView.backgroundColor = color
            view.addSubview(statusbarView)
            
            statusbarView.translatesAutoresizingMaskIntoConstraints = false
            statusbarView.heightAnchor
                  .constraint(equalToConstant: statusBarHeight).isActive = true
            statusbarView.widthAnchor
                  .constraint(equalTo: view.widthAnchor, multiplier: 1.0).isActive = true
            statusbarView.topAnchor
                  .constraint(equalTo: view.topAnchor).isActive = true
            statusbarView.centerXAnchor
                  .constraint(equalTo: view.centerXAnchor).isActive = true
        } else {
            if let statusBar: UIView = UIApplication.shared.value(forKey: "statusBar") as? UIView {
                statusBar.backgroundColor = color
            }
        }
    }
    
    @objc func gotoBack() {
        self.view.endEditing(true)
        self.navigationController?.pop(animated: true)
    }
    
    @objc func dismissView() {
        self.view.endEditing(true)
        self.dismiss(animated: true, completion: nil)
    }
    
    func backButton() {
        self.view.endEditing(true)
        self.navigationController?.setNavigationBarHidden(false, animated: false)
        let barButton = UIBarButtonItem(image: UIImage(named: "ic_back"), style: .plain, target: self, action: #selector(UIViewController.gotoBack))
        barButton.tintColor = UIColor.white
        self.navigationItem.leftBarButtonItem = barButton
        self.navigationController?.navigationBar.titleTextAttributes = [ NSAttributedString.Key.font : UIFont(name: "ABeeZee-Italic", size: 28)! , NSAttributedString.Key.foregroundColor: UIColor.white]
    }
    
    func closeButton() {
        self.view.endEditing(true)
        self.navigationController?.setNavigationBarHidden(false, animated: false)
        let barButton = UIBarButtonItem(image: UIImage(named: "ic_close"), style: .plain, target: self, action: #selector(UIViewController.gotoBack))
        barButton.tintColor = UIColor(named: HiveColor.ThemeGrey.rawValue)
        self.navigationItem.leftBarButtonItem = barButton
        self.navigationController?.navigationBar.titleTextAttributes = [ NSAttributedString.Key.font : UIFont(name: "ABeeZee-Italic", size: 28)! , NSAttributedString.Key.foregroundColor: UIColor.black]
    }

    func pullDownButton(completion : @escaping (String) -> ()) {
        self.view.endEditing(true)
        self.navigationController?.setNavigationBarHidden(false, animated: false)
        let filterPullDownButtom = UIButton(frame: CGRect(x: 0, y: 0, width: 44, height: 44))

        let optionClosure = {(action: UIAction) in
            completion(action.title)
            filterPullDownButtom.setTitle(action.title, for: .normal)
//            guard let index = self.hiveSetupDataArray?.firstIndex(where: {$0.name == action.title}) else { return }
//            for (getIndex,_) in (self.hiveSetupDataArray ?? []).enumerated() {
//                self.hiveSetupDataArray?[getIndex].isSelected = false
//            }
//            self.hiveSetupDataArray?[index].isSelected = true
        }
        var arrUIAction = [UIAction]()
        for intData in 1...10 {
            arrUIAction.append(UIAction(title: intData.string, state: .off, handler: optionClosure))
        }
        filterPullDownButtom.setTitleColor(.black, for: .normal)
        filterPullDownButtom.setTitle("1", for: .normal)
        filterPullDownButtom.menu = UIMenu(children: arrUIAction)
        filterPullDownButtom.showsMenuAsPrimaryAction = true
        if #available(iOS 15.0, *) {
            filterPullDownButtom.changesSelectionAsPrimaryAction = true
        }
        filterPullDownButtom.titleLabel?.font = UIFont(name: "ABeeZee-Italic", size: 20)!
        let barButton = UIBarButtonItem(customView: filterPullDownButtom)
        barButton.tintColor = UIColor(named: HiveColor.ThemeGrey.rawValue)
        self.navigationItem.rightBarButtonItem = barButton
        self.navigationController?.navigationBar.titleTextAttributes = [ NSAttributedString.Key.font : UIFont(name: "ABeeZee-Italic", size: 28)! , NSAttributedString.Key.foregroundColor: UIColor.black]
    }
    
    func showTransparentNavigationBar() {
        self.navigationController?.isNavigationBarHidden = true
        self.navigationController?.navigationBar.setBackgroundImage(UIImage(), for: .default)
        self.navigationController?.navigationBar.shadowImage = UIImage()
        self.navigationController?.navigationBar.isTranslucent = true
        self.navigationController?.view.backgroundColor = .clear
        self.navigationController?.navigationBar.backgroundColor = .clear
        self.navigationController?.navigationBar.tintColor  = .clear
    }
    
    func showColoredNavigationBar(_ color: UIColor) {
        self.navigationController?.isNavigationBarHidden = false
        self.navigationController?.navigationBar.setBackgroundImage(UIImage(), for: UIBarMetrics.default)
        self.navigationController?.navigationBar.shadowImage = UIImage()
        self.navigationController?.navigationBar.isTranslucent = true
        self.navigationController?.view.backgroundColor = color
        self.navigationController?.navigationBar.backgroundColor = color
        self.navigationController?.navigationBar.tintColor  = color
        self.navigationController?.navigationBar.titleTextAttributes = [ NSAttributedString.Key.font : UIFont(name: "ABeeZee-Italic", size: 28)! , NSAttributedString.Key.foregroundColor: UIColor.black]
    }
    
    func clearNavigationBar() {
        self.navigationController?.navigationBar.backgroundColor = UIColor.clear
        self.navigationController?.navigationBar.tintColor  = UIColor.white
        self.navigationController?.navigationBar.barTintColor = UIColor.clear
        self.navigationController?.navigationBar.isTranslucent = true
        self.navigationController?.navigationBar.titleTextAttributes = [ NSAttributedString.Key.font : UIFont(name: "ABeeZee-Italic", size: 28)! , NSAttributedString.Key.foregroundColor: UIColor.black]
    }
}

extension UINavigationController {
    
    func hideNavigationBar() {
        self.navigationController?.navigationBar.isHidden = true
    }
    
    func showNavigationBar() {
        self.navigationController?.navigationBar.isHidden = false
    }
    
    func pop(animated: Bool) {
        _ = self.popViewController(animated: animated)
    }
    
    func popToRoot(animated: Bool) {
        _ = self.popToRootViewController(animated: animated)
    }
}

extension DateFormatter
{
    func setLocal() {
        self.locale = Locale.init(identifier: "en_US_POSIX")
        self.timeZone = TimeZone(abbreviation: "EDT")!
    }
}

extension Date {
    var ticks: UInt64 {
        return UInt64((self.timeIntervalSince1970 + 62_135_596_800) * 10_000_000)
    }
    func currentTimeMillis() -> Int64 {
        return Int64(self.timeIntervalSince1970 * 1000)
    }
    var startOfDay: Date {
        
        let calendar = Calendar.current
        let unitFlags = Set<Calendar.Component>([.year, .month, .day])
        let components = calendar.dateComponents(unitFlags, from: self)
        return calendar.date(from: components)!
    }
    
    var endOfDay: Date {
        
        var components = DateComponents()
        components.day = 1
        let date = Calendar.current.date(byAdding: components, to: self.startOfDay)
        return (date?.addingTimeInterval(-1))!
    }
    
    var yesterday: Date {
        let calendar = Calendar.current
        return (calendar as NSCalendar).date(byAdding: .day, value: -1, to: Date(), options: .matchStrictly)!.dateWithNoTime()
    }
    
    public func dateWithNoTime()->Date{
        let calendar = Calendar.current
        let date = calendar.startOfDay(for: self)
        return date
    }
    
    func startOfMonth() -> Date {
        let calendar = Calendar.init(identifier: .gregorian)
        return calendar.date(from: calendar.dateComponents([.year, .month], from: Calendar.current.startOfDay(for: self)))!
    }
    
    func endOfMonth() -> Date {
        let calendar = Calendar.init(identifier: .gregorian)
        return calendar.date(byAdding: DateComponents(month: 1, day: -1), to: self.startOfMonth())!
    }
    
    func isGreaterThanDate(_ dateToCompare: Date) -> Bool {
        
        //Declare Variables
        var isGreater = false
        
        //Compare Values
        if self.compare(dateToCompare) == ComparisonResult.orderedDescending {
            isGreater = true
        }
        
        //Return Result
        return isGreater
    }
    
    func isLessThanDate(_ dateToCompare: Date) -> Bool {
        
        //Declare Variables
        var isLess = false
        
        //Compare Values
        if self.compare(dateToCompare) == ComparisonResult.orderedAscending {
            isLess = true
        }
        
        //Return Result
        return isLess
    }
    
    func equalToDate(_ dateToCompare: Date) -> Bool {
        
        //Declare Variables
        var isEqualTo = false
        
        //Compare Values
        if self.compare(dateToCompare) == ComparisonResult.orderedSame {
            isEqualTo = true
        }
        
        //Return Result
        return isEqualTo
    }
}

extension UISearchBar {
    
    func setTextColor(color: UIColor) {
        let svs = subviews.flatMap { $0.subviews }
        guard let tf = (svs.filter { $0 is UITextField }).first as? UITextField else { return }
        tf.textColor = color
    }
}


extension Sequence where Iterator.Element == (key: String, value: Any) {
    var jsonString : String {
        do {
            let jsonData = try JSONSerialization.data(withJSONObject: self, options: .prettyPrinted)
            return String(data: jsonData, encoding: .utf8)!
        }
        catch {
            return ""
        }
    }
}
extension String {
    var jsonObject : [String: Any]? {
        if let data = self.data(using: String.Encoding.utf8) {
            do {
                return try JSONSerialization.jsonObject(with: data, options: .mutableContainers) as? [String:Any]
                
            } catch {
                
            }
        }
        return nil
    }
}

extension Bundle {
    var releaseVersionNumber: String? {
        return infoDictionary?["CFBundleShortVersionString"] as? String
    }
    var buildVersionNumber: String? {
        return infoDictionary?["CFBundleVersion"] as? String
    }
}

func buildVersionNumber() -> String{
    let str = "\(Bundle.main.releaseVersionNumber ?? "1.0") (\(Bundle.main.buildVersionNumber ?? "1"))"
    return str
}

extension UIDevice {
    
    
    enum DeviceType: String {
        case iPhone4_4S = "iPhone 4 or iPhone 4S"
        case iPhones_5_5s_5c_SE = "iPhone 5, iPhone 5s, iPhone 5c or iPhone SE"
        case iPhones_6_6s_7_8 = "iPhone 6, iPhone 6S, iPhone 7 or iPhone 8"
        case iPhones_6Plus_6sPlus_7Plus_8Plus = "iPhone 6 Plus, iPhone 6S Plus, iPhone 7 Plus or iPhone 8 Plus"
        case iPhoneX = "iPhone X"
        case unknown = "iPadOrUnknown"
    }
    
    var deviceType: DeviceType {
        switch UIScreen.main.nativeBounds.height {
        case 960:
            return .iPhone4_4S
        case 1136:
            return .iPhones_5_5s_5c_SE
        case 1334:
            return .iPhones_6_6s_7_8
        case 1920, 2208:
            return .iPhones_6Plus_6sPlus_7Plus_8Plus
        case 2436:
            return .iPhoneX
        default:
            return .unknown
        }
    }
}

extension Bundle {
    func getAppName() -> String {
        guard let name = object(forInfoDictionaryKey: "CFBundleDisplayName") as? String else { return "" }
        return name
    }
}

extension NSRegularExpression {
    func matches(_ string: String) -> Bool {
        let range = NSRange(location: 0, length: string.utf16.count)
        return firstMatch(in: string, options: [], range: range) != nil
    }
    
    convenience init(_ pattern: String) {
        do {
            try self.init(pattern: pattern)
        } catch {
            preconditionFailure("Illegal regular expression: \(pattern).")
        }
    }
}

extension UIActivity.ActivityType {
    static let InviteFriend =
        UIActivity.ActivityType("com.customActivity.InviteFriend")
}

class ExampleActivity: UIActivity {
    var _activityTitle: String
    var _activityImage: UIImage?
    var activityItems = [Any]()
    var action: ([Any]) -> Void
    
    init(title: String, image: UIImage?, performAction: @escaping ([Any]) -> Void) {
        _activityTitle = title
        _activityImage = image
        action = performAction
        super.init()
    }
    
    override var activityTitle: String? {
        return _activityTitle
    }

    override var activityImage: UIImage? {
        return UIImage(named: "ic_appIcon.png")
    }
    
    override var activityType: UIActivity.ActivityType? {
        return UIActivity.ActivityType.InviteFriend
    }

    override class var activityCategory: UIActivity.Category {
        return .action
    }
    
    override func canPerform(withActivityItems activityItems: [Any]) -> Bool {
        return true
    }
    
    override func prepare(withActivityItems activityItems: [Any]) {
        self.activityItems = activityItems
    }
    
    override func perform() {
        action(activityItems)
        activityDidFinish(true)
    }
}

extension UITableView {
    func setEmptyMessage(_ message: String) {
//        guard self.numberOfRows() == 0 else {
//            return
//        }
        let messageLabel = UILabel(frame: CGRect(x: 0, y: 0, width: self.bounds.size.width, height: self.bounds.size.height))
        messageLabel.text = message
        messageLabel.textColor = .white
        messageLabel.numberOfLines = 0
        messageLabel.textAlignment = .center
        messageLabel.font = UIFont.init(name: "ABeeZee-Italic", size: 15.0)
        messageLabel.textColor = UIColor.black
        messageLabel.font = UIFont.systemFont(ofSize: 14.0, weight: .medium)
        messageLabel.sizeToFit()

        self.backgroundView = messageLabel;
        self.separatorStyle = .none;
    }

    func restore() {
        self.backgroundView = nil
        self.separatorStyle = .singleLine
    }
}

extension UICollectionView {
    func setEmptyMessage(_ message: String) {
        guard self.numberOfItems() == 0 else {
            return
        }

        let messageLabel = UILabel(frame: CGRect(x: 0, y: 0, width: self.bounds.size.width, height: self.bounds.size.height))
        messageLabel.text = message
        messageLabel.textColor = .black
        messageLabel.numberOfLines = 0
        messageLabel.textAlignment = .center
        messageLabel.font = UIFont.init(name: "ABeeZee-Italic", size: 15.0)
        messageLabel.textColor = UIColor.black
        messageLabel.sizeToFit()
        self.backgroundView = messageLabel;
    }

    func restore() {
        self.backgroundView = nil
    }
}

extension Date {
    func get(_ components: Calendar.Component..., calendar: Calendar = Calendar.current) -> DateComponents {
        return calendar.dateComponents(Set(components), from: self)
    }

    func get(_ component: Calendar.Component, calendar: Calendar = Calendar.current) -> Int {
        return calendar.component(component, from: self)
    }
}

extension String {
    func encode() -> String {
        let data = self.data(using: .nonLossyASCII, allowLossyConversion: true)!
        return String(data: data, encoding: .utf8)!
    }
    
    func decode() -> String? {
        let data = self.data(using: .utf8)!
        return String(data: data, encoding: .nonLossyASCII)
    }
}

extension Sequence where Element: AdditiveArithmetic {
    func sum() -> Element { reduce(.zero, +) }
}
