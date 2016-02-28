//
//  InterfaceController.swift
//  totd WatchKit Extension
//
//  Created by Bill Snook on 2/25/16.
//  Copyright © 2016 BillSnook. All rights reserved.
//

import WatchKit
import Foundation
import SwiftyJSON
import XCGLogger

let jotdSrcURL = "/json-text.php"


class InterfaceController: WKInterfaceController {

    @IBOutlet var jotdButton: WKInterfaceButton!
    @IBOutlet var totdButton: WKInterfaceButton!
    @IBOutlet var textDisplayLabel: WKInterfaceLabel!
    
    
    override func awakeWithContext(context: AnyObject?) {
        super.awakeWithContext(context)
        
        // Configure interface objects here.
        
        log.debug( "initial message for WatchKit InterfaceController" )
        
        if messageSelection == nil {
            messageSelection = 0
        }
        
        textDisplayLabel.setText( Utilities.messageLabel( messageSelection! ) )
    }
    
    override func willActivate() {
        // This method is called when watch view controller is about to be visible to user
        super.willActivate()
        
        
        Network.getJokeData( returnJokes )
        
    }
    
    override func didDeactivate() {
        // This method is called when watch view controller is no longer visible
        super.didDeactivate()
    }
    
	func returnJokes( resultJokes: JSON?, index: Int ) -> () {
//		print( "Got result: \(resultJokes)" )
        
        if let jsonResult = resultJokes?[0] {
            setupDisplay( jsonResult )
        } else {
            print( "No jokes returned" )
        }
        
    }
    
    func setupDisplay( resultJokes: JSON ) {
//        print( "setupDisplay: \(resultJokes)" )
        
        let jotd = resultJokes["jotd"].stringValue
        
        self.textDisplayLabel.setText( jotd )
    }
    
    @IBAction func selectJOTD() {
        messageSelection = 0
//        network!.queueRequest( network!.URLFromPath( Utilities.messageName( messageSelection! ) + jotdSrcURL ), completion: { (result) -> () in
//            log.debug( "completion for queueRequest for jotd: \(result)" )
//            self.textDisplayLabel.setText( result )
//        })
    }
    
    @IBAction func selectTOTD() {
        messageSelection = 1
//        network!.queueRequest( network!.URLFromPath( Utilities.messageName( messageSelection! ) + jotdSrcURL ), completion: { (result) -> () in
//            log.debug( "completion for queueRequest for totd: \(result)" )
//            self.textDisplayLabel.setText( result )
//        })
    }
    
}
