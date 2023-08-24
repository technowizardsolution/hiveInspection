//
//  Int+Extension.swift
//  Pods
//
//  Created by Lokesh on 09/05/16.
//
//

import Foundation

// MARK: - Int Extension -
public extension Int {
    var toBinaryString: String {
        return String(self, radix: 2)
    }
    var toHexaString: String {
        return String(self, radix: 16)
    }
    var string : String {
        return String(self)
    }
    var day: (Int, Calendar.Component) {
        return (self, Calendar.Component.day)
    }
    var month: (Int, Calendar.Component) {
        return (self, Calendar.Component.month)
    }
    var year: (Int, Calendar.Component) {
        return (self, Calendar.Component.year)
    }
    var minute: (Int, Calendar.Component) {
        return (self, Calendar.Component.minute)
    }
    var hour: (Int, Calendar.Component) {
        return (self, Calendar.Component.hour)
    }
    var second: (Int, Calendar.Component) {
        return (self, Calendar.Component.second)
    }
    var nanosecond: (Int, Calendar.Component) {
        return (self, Calendar.Component.nanosecond)
    }
    var weekofyear: (Int, Calendar.Component) {
        return (self, Calendar.Component.weekOfYear)
    }
    var era: (Int, Calendar.Component) {
        return (self, Calendar.Component.era)
    }
    var weekday: (Int, Calendar.Component) {
        return (self, Calendar.Component.weekday)
    }
    var weekdayordinal: (Int, Calendar.Component) {
        return (self, Calendar.Component.weekdayOrdinal)
    }
    var quarter: (Int, Calendar.Component) {
        return (self, Calendar.Component.quarter)
    }
    var weekofmonth: (Int, Calendar.Component) {
        return (self, Calendar.Component.weekOfMonth)
    }
}
