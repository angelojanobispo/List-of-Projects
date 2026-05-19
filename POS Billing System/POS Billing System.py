def Receipt():
    print("\nWelcome to Comfee Cafe")

    print("Here's the menu\n")
    print("                                                      Price")
    print("            Product                            Small  Medium  Large")
    print("1. Vanilla Sweet Cream Cold Brew                100    150     200")
    print("2. Vanilla Sweet Cream Nitro                    100    150     200")
    print("3. Vanilla Oatmilk Shaken Espresso              100    150     200")

    print("\nComfee Original\n")
    print("4. Comfee Classic                               100    150     200")
    print("5. Vanilla Milk Brewed Coffee                   100    150     200")


    Loop_Input = input("\nHow many items are you interested in buying? ")
    if Loop_Input.isdigit():
        Loop=int(Loop_Input)
    else:
            print("\nInvalid Input Reset the Program")
            quit()
    if Loop ==0:
        print("\nThank you for visiting the shop!")
        quit()
    Name = str(input("Enter Your Name: "))

    Cost =0

    VanillaSweetCreamColdBrew=0
    SmallVanillaSweetCreamColdBrew=0
    MediumVanillaSweetCreamColdBrew=0
    LargeVanillaSweetCreamColdBrew=0

    VanillaSweetCreamNitro =0
    SmallVanillaSweetCreamNitro=0
    MediumVanillaSweetCreamNitro=0
    LargeVanillaSweetCreamNitro=0

    VanillaOutMilkShakenEspresso=0
    SmallVanillaOutMilkShakenEspresso=0
    MediumVanillaOutMilkShakenEspresso=0
    LargeVanillaOutMilkShakenEspresso=0

    ComfeeClassic=0
    SmallComfeeClassic=0
    MediumComfeeClassic=0
    LargeComfeeClassic=0

    VanillaMilkBrewedCoffee=0
    SmallVanillaMilkBrewedCoffee=0
    MediumVanillaMilkBrewedCoffee=0
    LargeVanillaMilkBrewedCoffee=0


    for x in range(Loop):
        Number_Input = input("\nChoose your desired product: ")
        if Number_Input.isdigit():
            Number = int(Number_Input)
        else:
            print("\nInvalid Input Reset The Program")
            quit()
        if Number==1:
            VanillaSweetCreamColdBrew+=1
            print("1. Small 2. Medium 3. Large")
            Size_Input = input("Enter the size of your choice (Using the number): ")
            if Size_Input.isdigit():
                Size = int(Size_Input)
            else:
                print("\nInvalid Input Reset The Program")
                quit()
            if Size==1:
                Cost+=100
                SmallVanillaSweetCreamColdBrew+=1
            elif Size==2:
                Cost+=150
                MediumVanillaSweetCreamColdBrew+=1
            elif Size==3:
                Cost+=200
                LargeVanillaSweetCreamColdBrew+=1
            else :
                print("\nInvalid Input Reset The Program")
                quit()

        elif Number==2:
             VanillaSweetCreamNitro+=1
             print("1. Small 2. Medium 3. Large")
             Size_Input = input("Enter the size of your choice (Using the number): ")
             if Size_Input.isdigit():
                 Size = int(Size_Input)
             else:
                 print("\nInvalid Input Reset The Program")
                 quit()
             if Size==1:
                 Cost+=100
                 SmallVanillaSweetCreamNitro+=1
             elif Size==2:
                 Cost+=150
                 MediumVanillaSweetCreamNitro+=1
             elif Size==3:
                 Cost+=200
                 LargeVanillaSweetCreamNitro+=1
             else :
                 print("\nInvalid Input Reset The Program")
                 quit()

        elif  Number==3:
             VanillaOutMilkShakenEspresso+=1
             print("1. Small 2. Medium 3. Large")
             Size_Input = input("Enter the size of your choice (Using the number): ")
             if Size_Input.isdigit():
                 Size = int(Size_Input)
             else:
                 print("\nInvalid Input Reset The Program")
                 quit()
             if Size ==1:
                 Cost+=100
                 SmallVanillaOutMilkShakenEspresso+=1
             elif Size==2:
                 Cost+=150
                 MediumVanillaOutMilkShakenEspresso+=1
             elif Size==3:
                 Cost+=200
                 LargeVanillaOutMilkShakenEspresso+=1
             else :
                 print("\nInvalid Input Reset The Program")
                 quit()

        elif Number==4:
            ComfeeClassic+=1
            print("1. Small 2. Medium 3. Large")
            Size_Input = input("Enter the size of your choice ")
            if Size_Input.isdigit():
                Size = int(Size_Input)
            else:
                print("\nInvalid Input Reset The Program")
                quit()
            if Size==1:
                Cost+=100
                SmallComfeeClassic+=1
            elif Size==2:
                Cost+=150
                MediumComfeeClassic+=1
            elif Size==3:
                Cost+=200
                LargeComfeeClassic+=1
            else:
                print("\nInvalid Input Reset The Program")
                quit()
        elif Number==5:
            VanillaMilkBrewedCoffee+=1
            print("1. Small 2. Medium 3. Large")
            Size_Input = input("Enter the size of your choice (Using the number): ")
            if Size_Input.isdigit():
                Size = int(Size_Input)
            else:
                print("\nInvalid Input Reset The Program")
                quit()
            if Size==1:
                Cost+=100
                SmallVanillaMilkBrewedCoffee+=1
            elif Size==2:
                Cost+=150
                MediumVanillaMilkBrewedCoffee+=1
            elif Size==3:
                Cost+=200
                LargeVanillaMilkBrewedCoffee+=1
            else:
                print("\nInvalid Input Reset The Program")
                quit()

        else:
            print("\nInvalid Input Reset The Program")
            quit()

    print("\n1. Student 2. Senior Citizen 3. PWD 4. None of the above")
    Discount_Input = input("Enter the number of where you belong: ")
    if Discount_Input.isdigit():
        Discount=int(Discount_Input)
    else:
        print("\nInvalid Input Reset The Program")
        quit()

    if Discount==1 or Discount==2 or Discount==3:
        Vat = Cost*.12
        SubTotal = Cost-Vat
        WithDiscount = Cost*.20
        NewTotal = Cost-WithDiscount
        print("\nThis is the overall price:",float(NewTotal))
        print("Please pay in whole number")
        Payment_Input=input("Put your payment in here: ")
        if Payment_Input.isdigit():
            Payment=int(Payment_Input)
        else:
            print("\nInvalid Input Reset the Program")
            quit()
        if Payment<NewTotal:
            print("\nNot enough balance")
            quit()
        print("\nComfee Cafe")
        print("Address: Cavite Civic Center, Cavite City, 4103 Cavite ")
        print("Contact Number: 09481339214")
        print("---------------------------------------------------------------------------------------------")
        print("\nProduct                                 Quantity          Price                Amount")

        if VanillaSweetCreamColdBrew!=0:
            print(VanillaSweetCreamColdBrew,"Vanilla Sweet Cream Cold Brew")
            if SmallVanillaSweetCreamColdBrew!=0:
                print("    -Small                                ",SmallVanillaSweetCreamColdBrew,"            100 Pesos           ",SmallVanillaSweetCreamColdBrew*100,"Pesos")
            if MediumVanillaSweetCreamColdBrew!=0:
                print("    -Medium                               ",MediumVanillaSweetCreamColdBrew,"            150 Pesos           ",MediumVanillaSweetCreamColdBrew*150,"Pesos")
            if LargeVanillaSweetCreamColdBrew!=0:
                print("    -Large                                ",LargeVanillaSweetCreamColdBrew,"            200 Pesos           ",LargeVanillaSweetCreamColdBrew*200,"Pesos")

        if VanillaSweetCreamNitro !=0:
            print(VanillaSweetCreamNitro,"Vanilla Sweet Cream Nitro")
            if SmallVanillaSweetCreamNitro!=0:
                print("    -Small                                ",SmallVanillaSweetCreamNitro,"            100 Pesos           ",SmallVanillaSweetCreamNitro*100,"Pesos")
            if MediumVanillaSweetCreamNitro!=0:
                print("    -Medium                               ",MediumVanillaSweetCreamNitro,"            150 Pesos           ",MediumVanillaSweetCreamNitro*150,"Pesos")
            if LargeVanillaSweetCreamNitro!=0:
                print("    -Large                                ",LargeVanillaSweetCreamNitro,"            200 Pesos           ",LargeVanillaSweetCreamNitro*200,"Pesos")

        if VanillaOutMilkShakenEspresso!=0:
            print(VanillaOutMilkShakenEspresso,"Vanilla OutMilk Shaken Espresso")
            if SmallVanillaOutMilkShakenEspresso!=0:
                print("    -Small                                ",SmallVanillaOutMilkShakenEspresso,"            100 Pesos           ",SmallVanillaOutMilkShakenEspresso*100,"Pesos")
            if MediumVanillaOutMilkShakenEspresso!=0:
                print("    -Medium                               ",MediumVanillaOutMilkShakenEspresso,"            150 Pesos           ",MediumVanillaOutMilkShakenEspresso*150,"Pesos")
            if LargeVanillaOutMilkShakenEspresso!=0:
                print("    -Large                                ",LargeVanillaOutMilkShakenEspresso,"            200 Pesos           ",LargeVanillaOutMilkShakenEspresso*200,"Pesos")

        if ComfeeClassic!=0:
            print(ComfeeClassic,"Comfee Classic")
            if SmallComfeeClassic!=0:
                print("    -Small                                ",SmallComfeeClassic,"            100 Pesos           ",SmallComfeeClassic*100,"Pesos")
            if MediumComfeeClassic!=0:
                print("    -Medium                               ",MediumComfeeClassic,"            150 Pesos           ",MediumComfeeClassic*150,"Pesos")
            if LargeComfeeClassic!=0:
                print("    -Large                                ",LargeComfeeClassic,"            200 Pesos           ",LargeComfeeClassic*200,"Pesos")

        if VanillaMilkBrewedCoffee!=0:
            print(VanillaMilkBrewedCoffee,"Vanilla Milk Brewed Coffee")
            if SmallVanillaMilkBrewedCoffee!=0:
                print("    -Small                                ",SmallVanillaMilkBrewedCoffee,"            100 Pesos           ",SmallVanillaMilkBrewedCoffee*100,"Pesos")
            if MediumVanillaMilkBrewedCoffee!=0:
                print("    -Medium                               ",MediumVanillaMilkBrewedCoffee,"            150 Pesos           ",MediumVanillaMilkBrewedCoffee*150,"Pesos")
            if LargeVanillaMilkBrewedCoffee!=0:
                print("    -Large                                ",LargeVanillaMilkBrewedCoffee,"            200 Pesos           ",LargeVanillaMilkBrewedCoffee*200,"Pesos")

        print("---------------------------------------------------------------------------------------------")
        TotalNumberOfProduct = VanillaSweetCreamColdBrew + VanillaSweetCreamNitro + VanillaOutMilkShakenEspresso + ComfeeClassic + VanillaMilkBrewedCoffee
        print("\nSubtotal                                                                     ", float(SubTotal), "Pesos")
        print("Vat                                                                          ",float(Vat),"Pesos")
        if Discount == 1:
            print("Student Discount                                                             ",float(WithDiscount),"Pesos")
        if Discount == 2:
            print("Senior Citizen Discount                                                      ",float(WithDiscount),"Pesos")
        if Discount == 3:
            print("PWD Discount                                                                 ",float(WithDiscount),"Pesos")
        print("Total                                                                        ", float(NewTotal),"Pesos")

        Change=Payment-NewTotal
        print("\nPayment                                                                      ",Payment,"Pesos")
        if Change ==1:
            print("Change                                                                       " ,float(Change),"Peso")
        else :
            print("Change                                                                       ",float(Change),"Pesos")

            print("---------------------------------------------------------------------------------------------")
            print(TotalNumberOfProduct,"Of Item Sold")
            print("---------------------------------------------------------------------------------------------")
            print("Buyer's Information")
            print("Name: ", Name)

            print("\nThank you for visiting Comfee Cafe")
            print("This serves as official receipt")
            print("THIS RECEIPT SHALL BE VALID FOR 24 HOURS FROM THE DATE OF THE RECEIPT")


    elif Discount==4:
        Vat = Cost*.12
        SubTotal = Cost-Vat
        NewTotal = Cost
        print("\nThis is the overall price: ",float(NewTotal))
        print("Please pay in whole number")
        Payment_Input=input("Put your payment in here: ")
        if Payment_Input.isdigit():
            Payment=int(Payment_Input)
        else:
            print("\nInvalid Input Reset the Program")
            quit()
        if Payment<NewTotal:
            print("\nNot enough balance")
            quit()
        print("\nComfee Cafe")
        print("Address: Cavite Civic Center, Cavite City, 4103 Cavite ")
        print("Contact Number: 09481339214")
        print("---------------------------------------------------------------------------------------------")
        print("\nProduct                                 Quantity          Price                Amount")

        if VanillaSweetCreamColdBrew!=0:
            print(VanillaSweetCreamColdBrew,"Vanilla Sweet Cream Cold Brew")
            if SmallVanillaSweetCreamColdBrew!=0:
                print("    -Small                                ",SmallVanillaSweetCreamColdBrew,"            100 Pesos           ",SmallVanillaSweetCreamColdBrew*100,"Pesos")
            if MediumVanillaSweetCreamColdBrew!=0:
                print("    -Medium                               ",MediumVanillaSweetCreamColdBrew,"            150 Pesos           ",MediumVanillaSweetCreamColdBrew*150,"Pesos")
            if LargeVanillaSweetCreamColdBrew!=0:
                print("    -Large                                ",LargeVanillaSweetCreamColdBrew,"            200 Pesos           ",LargeVanillaSweetCreamColdBrew*200,"Pesos")

        if VanillaSweetCreamNitro !=0:
            print(VanillaSweetCreamNitro,"Vanilla Sweet Cream Nitro")
            if SmallVanillaSweetCreamNitro!=0:
                print("    -Small                                ",SmallVanillaSweetCreamNitro,"            100 Pesos           ",SmallVanillaSweetCreamNitro*100,"Pesos")
            if MediumVanillaSweetCreamNitro!=0:
                print("    -Medium                               ",MediumVanillaSweetCreamNitro,"            150 Pesos           ",MediumVanillaSweetCreamNitro*150,"Pesos")
            if LargeVanillaSweetCreamNitro!=0:
                print("    -Large                                ",LargeVanillaSweetCreamNitro,"            200 Pesos           ",LargeVanillaSweetCreamNitro*200,"Pesos")

        if VanillaOutMilkShakenEspresso!=0:
            print(VanillaOutMilkShakenEspresso,"Vanilla OutMilk Shaken Espresso")
            if SmallVanillaOutMilkShakenEspresso!=0:
                print("    -Small                                ",SmallVanillaOutMilkShakenEspresso,"            100 Pesos           ",SmallVanillaOutMilkShakenEspresso*100,"Pesos")
            if MediumVanillaOutMilkShakenEspresso!=0:
                print("    -Medium                               ",MediumVanillaOutMilkShakenEspresso,"            150 Pesos           ",MediumVanillaOutMilkShakenEspresso*150,"Pesos")
            if LargeVanillaOutMilkShakenEspresso!=0:
                print("    -Large                                ",LargeVanillaOutMilkShakenEspresso,"            200 Pesos           ",LargeVanillaOutMilkShakenEspresso*200,"Pesos")

        if ComfeeClassic!=0:
            print(ComfeeClassic,"Comfee Classic")
            if SmallComfeeClassic!=0:
                print("    -Small                                ",SmallComfeeClassic,"            100 Pesos           ",SmallComfeeClassic*100,"Pesos")
            if MediumComfeeClassic!=0:
                print("    -Medium                               ",MediumComfeeClassic,"            150 Pesos           ",MediumComfeeClassic*150,"Pesos")
            if LargeComfeeClassic!=0:
                print("    -Large                                ",LargeComfeeClassic,"            200 Pesos           ",LargeComfeeClassic*200,"Pesos")

        if VanillaMilkBrewedCoffee!=0:
            print(VanillaMilkBrewedCoffee,"Vanilla Milk Brewed Coffee")
            if SmallVanillaMilkBrewedCoffee!=0:
                print("    -Small                                ",SmallVanillaMilkBrewedCoffee,"            100 Pesos           ",SmallVanillaMilkBrewedCoffee*100,"Pesos")
            if MediumVanillaMilkBrewedCoffee!=0:
                print("    -Medium                               ",MediumVanillaMilkBrewedCoffee,"            150 Pesos           ",MediumVanillaMilkBrewedCoffee*150,"Pesos")
            if LargeVanillaMilkBrewedCoffee!=0:
                print("    -Large                                ",LargeVanillaMilkBrewedCoffee,"            200 Pesos           ",LargeVanillaMilkBrewedCoffee*200,"Pesos")


        print("---------------------------------------------------------------------------------------------")
        TotalNumberOfProduct = VanillaSweetCreamColdBrew + VanillaSweetCreamNitro + VanillaOutMilkShakenEspresso + ComfeeClassic + VanillaMilkBrewedCoffee
        print("\nSubtotal                                                                     ", float(SubTotal), "Pesos")
        print("Vat                                                                          ",float(Vat),"Pesos")
        print("Total                                                                        ",float(NewTotal),"Pesos")
        Change=Payment-NewTotal
        print("\nPayment                                                                      ",Payment,"Pesos")
        if Change ==1:
            print("Change                                                                       " ,float(Change),"Peso")
        else :
            print("Change                                                                       ",float(Change),"Pesos")

            print("---------------------------------------------------------------------------------------------")
            print(TotalNumberOfProduct,"Of Item Sold")
            print("---------------------------------------------------------------------------------------------")
            print("Buyer's Information")
            print("Name: ", Name)

            print("\nThank you for visiting Comfee Cafe!")
            print("This serves as official receipt")
            print("THIS RECEIPT SHALL BE VALID FOR 24 HOURS FROM THE DATE OF THE RECEIPT")

    else:
        print("\nInvalid Input Reset the Program")
        quit()
        
    OrderAgain = input("\nDo you want to order again(y/n)? ")
    if OrderAgain=="y":
        Receipt()
    elif OrderAgain== "n":
        print("\nThank you for visiting Comfee Cafe!")
        quit()
    else :
        print("\nInvalid Input Reset The Program")
        quit()
      
Receipt()
