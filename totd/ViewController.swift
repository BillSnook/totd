//
//  ViewController.swift
//  totd
//
//  Created by Bill Snook on 2/25/16.
//  Copyright © 2016 BillSnook. All rights reserved.
//

import UIKit
//import CoreData
import SwiftyJSON


let fontStyle = UIFontTextStyleHeadline


class ViewController: UIViewController {

	
	@IBOutlet weak var messageControl: UISegmentedControl!
	@IBOutlet weak var messageLabel: UILabel!
	
	var messagePath: String?
	var messageSelection: Int?
	

	override func viewDidLoad() {
		super.viewDidLoad()

#if	DEBUG
		log.debug( "debug mode set" )
#endif
		messageSelection = 0
		messageControl.selectedSegmentIndex = messageSelection!
		messageControl.setTitle( Utilities.messageLabel( 0 ), forSegmentAtIndex: 0 )
		messageControl.setTitle( Utilities.messageLabel( 1 ), forSegmentAtIndex: 1 )
		
		messagePath = Utilities.messageName( messageSelection! )
		log.debug( "intial message for app, message type selected is <\(messagePath)>" )
		
		
		messageLabel.font = UIFont.preferredFontForTextStyle(fontStyle)
		
		NSNotificationCenter.defaultCenter().addObserver(self,
			selector: "preferredContentSizeChanged:",
			name: UIContentSizeCategoryDidChangeNotification,
			object: nil)
	}

	override func viewWillAppear(animated: Bool) {
		
		updateMessage()
	}
	
	override func didReceiveMemoryWarning() {
		super.didReceiveMemoryWarning()
		// Dispose of any resources that can be recreated.
	}

	func preferredContentSizeChanged(notification: NSNotification) {
		messageLabel.font = UIFont.preferredFontForTextStyle(fontStyle)
		log.debug( "content size category changed" )
	}
	
	private func updateMessage() {
		
		Network.getJokeData( returnJokes )
		
	}
	
	func returnJokes( resultJokes: JSON? ) -> () {
//		print( "Got result: \(resultJokes)" )
		
		if let jsonResult = resultJokes?[0] {
			setupDisplay( jsonResult )
		} else {
			print( "No jokes returned" )
		}
		
	}
	
	func setupDisplay( resultJokes: JSON ) {
//		print( "setupDisplay: \(resultJokes)" )
		
		let jotd = resultJokes["jotd"].stringValue
		
		self.messageLabel.text = jotd
	}
	
	@IBAction func changeMessageType(sender: UISegmentedControl) {
		let segCtl = sender
		messageSelection = segCtl.selectedSegmentIndex
		messagePath = Utilities.messageName( messageSelection! )
		log.debug( "selected message type is now <\(segCtl.titleForSegmentAtIndex( messageSelection! )!)>" )
		updateMessage()
	}
	
}

