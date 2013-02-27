using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Task1
{
    class Teacher : People
    {
        public List<Discipline> Discplines { get; set; }
      
        public Teacher(string name)
        {
            this.Discplines = new List<Discipline>();
            this.Name = name;
        }
    }
}
