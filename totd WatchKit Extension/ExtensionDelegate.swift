//
//  ExtensionDelegate.swift
//  totd WatchKit Extension
//
//  Created by Bill Snook on 2/25/16.
//  Copyright © 2016 BillSnook. All rights reserved.
//

import WatchKit
import XCGLogger


let log = XCGLogger.defaultInstance()

var messageSelection: Int?


class ExtensionDelegate: NSObject, WKExtensionDelegate {
    
    func applicationDidFinishLaunching() {
        // Perform any final initialization of your application.
        
        // Setup debug logger
        log.setup(.Debug, showThreadName: true, showLogLevel: true, showFileNames: true, showLineNumbers: true, writeToFile: nil, fileLogLevel: nil)
        let dateFormatter = NSDateFormatter()
        dateFormatter.dateFormat = "mm:ss.SSS"		// Short time string - minute, seconds, thousandth of a second
        dateFormatter.locale = NSLocale.currentLocale()
        log.dateFormatter = dateFormatter
        
        messageSelection = 0
    }

    func applicationDidBecomeActive() {
        // Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
    }

    func applicationWillResignActive() {
        // Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
        // Use this method to pause ongoing tasks, disable timers, etc.
    }

}
