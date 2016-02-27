//
//  Utilities.swift
//  jotd
//
//  Created by Bill Snook on 8/30/15.
//  Copyright (c) 2015 BillSnook. All rights reserved.
//

import Foundation

class Utilities: NSObject {
	
	class func messageName( index: Int ) -> String {
		switch ( index ) {
		case 0: return "jotd"
		case 1: return "totd"
		default: return "jotd"
		}
		
	}
	
	class func messageTitle( index: Int ) -> String {
		switch ( index ) {
		case 0: return "JOTD"
		case 1: return "TOTD"
		default: return "JOTD"
		}
		
	}
	
	class func messageLabel( index: Int ) -> String {
		switch ( index ) {
		case 0: return "Joke of the Day"
		case 1: return "Thought of the Day"
		default: return "Joke of the Day"
		}
		
	}
	
}