//
//  Network.swift
//  jotd
//
//  Created by William Snook on 1/17/16.
//  Copyright © 2016 William Snook. All rights reserved.
//

import Foundation
import Alamofire
import SwiftyJSON


typealias JokeBlock = (JSON?) -> ()


class Network {
    
    class func getJokeData( jokesReturn: JokeBlock ) {
		print( "getJokeData" )
        
        // Get dates from start date
        var jidx = 1
        let dateFormatter = NSDateFormatter()
        dateFormatter.dateFormat = "yyyy-MM-dd"
        if let myStartDate = NSUserDefaults.standardUserDefaults().valueForKey( "myStartDate" ) as! String? {
            
            let startDate = dateFormatter.dateFromString( myStartDate )
            let endDate = NSDate()
            
            let cal = NSCalendar.currentCalendar()
            let unit: NSCalendarUnit = .Day
            
            let components = cal.components(unit, fromDate: startDate!, toDate: endDate, options: NSCalendarOptions(rawValue: 0))
//            print( components )
            jidx = components.day       // 0..n
            print( "jidx: \(jidx)" )
        } else {
            let startDate = dateFormatter.stringFromDate( NSDate() )
            
            NSUserDefaults.standardUserDefaults().setValue(startDate, forKey: "myStartDate")
            NSUserDefaults.standardUserDefaults().synchronize()
        }
        
//        let jidxString = String( jidx )
        jidx = 3        // WFS test
        Alamofire.request(.GET, "http://www.billsnook.com/xperimentl/jotd/json-text.php" , parameters: ["jidx": "\(jidx)" ])
            .responseJSON { response in
                var json: JSON?
                switch response.result {
                case .Success:
                    if let value = response.result.value {
//                        print( "Value: \(value)")
                        json = JSON(value)
                        print( "JSON:\n\(json)" )
                    } else {
                        print( "Problem: response value not found" )
                    }
                case .Failure(let error):
                    print( "URLRequest failure: \(error)" )
                    print( response.result.value )
                }
                jokesReturn( json )
            }
        
    }
    
}
